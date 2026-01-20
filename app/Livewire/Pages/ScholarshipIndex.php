<?php

namespace App\Livewire\Pages;

use App\Models\Scholarship;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use App\Models\SavedSearch;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;

#[Layout('layouts.frontend')]
class ScholarshipIndex extends Component
{
    use WithPagination;
    use \App\Livewire\Traits\CanSaveScholarship;

    #[Url(as: 'sort')]
    public $sortBy = 'relevance';

    // Filter state
    public $filters = [
        'search' => '',
        'selectedCountries' => [],
        'selectedLevels' => [],
        'selectedFields' => [],
        'awardMin' => 0,
        'awardMax' => 100000,
        'selectedTypes' => [],
    ];

    #[On('filters-updated')]
    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public $viewMode = 'grid';
    public $perPage = 12;

    public function mount()
    {
        $this->viewMode = session('viewMode', 'grid');
        $this->mountCanSaveScholarship();
    }

    public function addToRecentSearches($term)
    {
        $recent = session()->get('recent_searches', []);

        // Remove if exists to move to top
        if (($key = array_search($term, $recent)) !== false) {
            unset($recent[$key]);
        }

        array_unshift($recent, $term);
        $recent = array_slice($recent, 0, 5);

        session()->put('recent_searches', $recent);
    }

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'grid' ? 'list' : 'grid';
        session()->put('viewMode', $this->viewMode);
    }

    public function loadMore()
    {
        $this->perPage += 12;
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCountries', 'selectedLevels', 'selectedFields', 'awardMin', 'awardMax', 'selectedTypes', 'sortBy']);
        $this->resetPage();
    }

    public function saveSearch()
    {
        // This will now be handled in the Filters component
    }

    public function render()
    {
        $baseQuery = Scholarship::query()
            ->where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->with(['countries', 'educationLevels', 'fieldsOfStudy', 'scholarshipTypes']);

        // Applying Filters to base query
        $this->applyFilters($baseQuery);

        // Fetch Premium Scholarships separately (up to 2)
        $premiumScholarships = (clone $baseQuery)
            ->where('sponsorship_tier', \App\Enums\SponsorshipTier::PREMIUM)
            ->latest()
            ->take(2)
            ->get();

        $premiumIds = $premiumScholarships->pluck('id')->toArray();

        // Main Query (excluding Premium items already shown)
        $query = (clone $baseQuery)->whereNotIn('id', $premiumIds);

        // Sorting
        match ($this->sortBy) {
            'deadline' => $query->orderBy('primary_deadline', 'asc'),
            'award_high' => $query->orderBy('award_amount', 'desc'),
            'newest' => $query->latest(),
            default => $query->orderByRaw("CASE sponsorship_tier 
                WHEN 'featured' THEN 1 
                ELSE 2 END ASC")->latest(),
        };

        $scholarships = $query->paginate($this->perPage);

        // If default sorting (Recommended), intersperse featured results
        if ($this->sortBy === 'relevance') {
            $this->intersperseFeaturedResults($scholarships);
        }

        app(\App\Services\MetaService::class)->setMeta(
            title: app(\App\Settings\SeoSettings::class)->scholarships_title ?? 'Browse Scholarships',
            description: app(\App\Settings\SeoSettings::class)->scholarships_description ?? 'Explore verified scholarships for undergraduate, masters, and PhD studies.',
        );

        return view('livewire.pages.scholarship-index', [
            'scholarships' => $scholarships,
            'premiumScholarships' => $premiumScholarships,
            'countries' => Country::orderBy('name', 'asc')->get(),
            'educationLevels' => EducationLevel::orderBy('name', 'asc')->get(),
            'fieldsOfStudy' => FieldOfStudy::whereNull('parent_id')
                ->with('children')
                ->orderBy('name', 'asc')
                ->get(),
            'scholarshipTypes' => \App\Models\ScholarshipType::all(),
            'recentSearches' => session()->get('recent_searches', []),
            'suggestions' => $this->filters['search'] ? $this->getSuggestions() : [],
        ]);
    }

    protected function applyFilters($query)
    {
        if ($this->filters['search']) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('provider_name', 'like', '%' . $this->filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $this->filters['search'] . '%');
            });
            $this->addToRecentSearches($this->filters['search']);
        }

        if (!empty($this->filters['selectedCountries'])) {
            $query->whereHas('countries', function ($q) {
                $q->whereIn('countries.slug', $this->filters['selectedCountries']);
            });
        }

        if (!empty($this->filters['selectedLevels'])) {
            $query->whereHas('educationLevels', function ($q) {
                $q->whereIn('education_levels.slug', $this->filters['selectedLevels']);
            });
        }

        if (!empty($this->filters['selectedFields'])) {
            $query->whereHas('fieldsOfStudy', function ($q) {
                $q->whereIn('field_of_studies.slug', $this->filters['selectedFields']);
            });
        }

        if ($this->filters['awardMin'] > 0 || $this->filters['awardMax'] < 100000) {
            $min = is_numeric($this->filters['awardMin']) ? $this->filters['awardMin'] : 0;
            $max = is_numeric($this->filters['awardMax']) ? $this->filters['awardMax'] : 100000;
            $query->whereBetween('award_amount', [$min, $max]);
        }

        if (!empty($this->filters['selectedTypes'])) {
            $query->whereHas('scholarshipTypes', function ($q) {
                $q->whereIn('scholarship_types.slug', $this->filters['selectedTypes']);
            });
        }
    }

    protected function intersperseFeaturedResults($paginator)
    {
        $items = $paginator->getCollection();
        $featured = $items->where('sponsorship_tier', \App\Enums\SponsorshipTier::FEATURED)->values();
        $standard = $items->where('sponsorship_tier', '!=', \App\Enums\SponsorshipTier::FEATURED)->values();

        $mixed = collect();
        $fIndex = 0;
        $sIndex = 0;

        // Intersperse: 1 featured every 3 standard (position 4, 8, 12...)
        while ($sIndex < $standard->count() || $fIndex < $featured->count()) {
            // Add up to 3 standard
            for ($i = 0; $i < 3 && $sIndex < $standard->count(); $i++) {
                $mixed->push($standard[$sIndex++]);
            }

            // Add 1 featured
            if ($fIndex < $featured->count()) {
                $mixed->push($featured[$fIndex++]);
            } elseif ($sIndex < $standard->count()) {
                // If no more featured, just keep pushing standard
                continue;
            }
        }

        $paginator->setCollection($mixed);
    }

    protected function getSuggestions()
    {
        $suggestions = [];

        if (strlen($this->filters['search']) < 2)
            return [];

        $fields = FieldOfStudy::where('name', 'like', '%' . $this->filters['search'] . '%', 'and')->take(3)->get();
        foreach ($fields as $field) {
            $suggestions[] = ['type' => 'field', 'label' => $field->name, 'value' => $field->slug];
        }

        $countries = Country::where('name', 'like', '%' . $this->filters['search'] . '%', 'and')->take(2)->get();
        foreach ($countries as $country) {
            $suggestions[] = ['type' => 'country', 'label' => $country->name, 'value' => $country->slug];
        }

        return $suggestions;
    }
}

<?php

namespace App\Livewire\Pages;

use App\Models\Scholarship;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

#[Layout('layouts.frontend')]
class ScholarshipIndex extends Component
{
    use WithPagination;
    use \App\Livewire\Traits\CanSaveScholarship;

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'country')]
    public $selectedCountry = '';

    #[Url(as: 'level')]
    public $selectedLevel = '';

    #[Url(as: 'field')]
    public $selectedField = '';

    #[Url(as: 'award_min')]
    public $awardMin = 0;

    #[Url(as: 'award_max')]
    public $awardMax = 100000;

    #[Url(as: 'types')]
    public $selectedTypes = [];

    #[Url(as: 'sort')]
    public $sortBy = 'relevance';

    public $viewMode = 'grid';
    public $perPage = 12;

    public function mount()
    {
        $this->viewMode = session('viewMode', 'grid');
        $this->mountCanSaveScholarship();
    }

    public function updatedSearch()
    {
        $this->perPage = 12;
        $this->resetPage();
        if (strlen($this->search) > 2) {
            $this->addToRecentSearches($this->search);
        }
    }

    public function updatedSelectedCountry()
    {
        $this->perPage = 12;
        $this->resetPage();
    }
    public function updatedSelectedLevel()
    {
        $this->perPage = 12;
        $this->resetPage();
    }
    public function updatedSelectedField()
    {
        $this->perPage = 12;
        $this->resetPage();
    }
    public function updatedAwardMin()
    {
        $this->perPage = 12;
        $this->resetPage();
    }
    public function updatedAwardMax()
    {
        $this->perPage = 12;
        $this->resetPage();
    }
    public function updatedSelectedTypes()
    {
        $this->perPage = 12;
        $this->resetPage();
    }
    public function updatedSortBy()
    {
        $this->perPage = 12;
        $this->resetPage();
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
        $this->reset(['search', 'selectedCountry', 'selectedLevel', 'selectedField', 'awardMin', 'awardMax', 'selectedTypes', 'sortBy']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Scholarship::query()
            ->where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->with(['countries', 'educationLevels', 'fieldsOfStudy', 'scholarshipTypes']);

        // Filtering
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('provider_name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedCountry) {
            $query->whereHas('countries', function ($q) {
                $q->where('countries.slug', $this->selectedCountry);
            });
        }

        if ($this->selectedLevel) {
            $query->whereHas('educationLevels', function ($q) {
                $q->where('education_levels.slug', $this->selectedLevel);
            });
        }

        if ($this->selectedField) {
            $query->whereHas('fieldsOfStudy', function ($q) {
                $q->where('field_of_studies.slug', $this->selectedField);
            });
        }

        if ($this->awardMin > 0 || $this->awardMax < 100000) {
            $min = is_numeric($this->awardMin) ? $this->awardMin : 0;
            $max = is_numeric($this->awardMax) ? $this->awardMax : 100000;
            $query->whereBetween('award_amount', [$min, $max]);
        }

        if (!empty($this->selectedTypes)) {
            $query->whereHas('scholarshipTypes', function ($q) {
                $q->whereIn('scholarship_types.slug', $this->selectedTypes);
            });
        }

        // Sorting
        match ($this->sortBy) {
            'deadline' => $query->orderBy('primary_deadline', 'asc'),
            'award_high' => $query->orderBy('award_amount', 'desc'),
            'newest' => $query->latest(),
            default => $query->orderByRaw("CASE sponsorship_tier 
                WHEN 'premium' THEN 1 
                WHEN 'featured' THEN 2 
                WHEN 'standard' THEN 3 
                ELSE 4 END ASC")->latest(),
        };

        $scholarships = $query->paginate($this->perPage);

        return view('livewire.pages.scholarship-index', [
            'scholarships' => $scholarships,
            'countries' => Country::orderBy('name')->get(),
            'educationLevels' => EducationLevel::orderBy('name')->get(),
            'fieldsOfStudy' => FieldOfStudy::whereNull('parent_id')->with('children')->orderBy('name')->get(),
            'scholarshipTypes' => \App\Models\ScholarshipType::all(),
            'recentSearches' => session()->get('recent_searches', []),
            'suggestions' => $this->search ? $this->getSuggestions() : [],
        ]);
    }

    protected function getSuggestions()
    {
        $suggestions = [];

        if (strlen($this->search) < 2)
            return [];

        $fields = FieldOfStudy::where('name', 'like', '%' . $this->search . '%')->take(3)->get();
        foreach ($fields as $field) {
            $suggestions[] = ['type' => 'field', 'label' => $field->name, 'value' => $field->slug];
        }

        $countries = Country::where('name', 'like', '%' . $this->search . '%')->take(2)->get();
        foreach ($countries as $country) {
            $suggestions[] = ['type' => 'country', 'label' => $country->name, 'value' => $country->slug];
        }

        return $suggestions;
    }
}

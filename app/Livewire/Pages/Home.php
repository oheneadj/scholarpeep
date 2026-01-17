<?php

namespace App\Livewire\Pages;

use App\Models\Scholarship;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.frontend')]
class Home extends Component
{
    use \App\Livewire\Traits\CanSaveScholarship;

    public function mount()
    {
        $this->mountCanSaveScholarship();
    }
    public $selectedTypeSlug = null;
    public $selectedFieldSlug = null;
    public $selectedLevelSlug = null;

    public function setType($slug)
    {
        $this->selectedTypeSlug = $this->selectedTypeSlug === $slug ? null : $slug;
    }

    public function setField($slug)
    {
        $this->selectedFieldSlug = $this->selectedFieldSlug === $slug ? null : $slug;
    }

    public function setLevel($slug)
    {
        $this->selectedLevelSlug = $this->selectedLevelSlug === $slug ? null : $slug;
    }

    public function render()
    {
        $premiumScholarships = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->where('sponsorship_tier', \App\Enums\SponsorshipTier::PREMIUM)
            ->with(['countries', 'educationLevels'])
            ->latest()
            ->take(3)
            ->get();

        $featuredScholarships = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->where('sponsorship_tier', \App\Enums\SponsorshipTier::FEATURED)
            ->with(['countries', 'educationLevels'])
            ->latest()
            ->take(6)
            ->get();

        $latestScholarships = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->with(['countries', 'educationLevels'])
            ->latest()
            ->take(6)
            ->get();

        $latestPosts = \App\Models\BlogPost::published()
            ->with('author')
            ->latest()
            ->take(3)
            ->get();

        // Calculate Type Section Scholarships
        if ($this->selectedTypeSlug) {
            $type = \App\Models\ScholarshipType::where('slug', $this->selectedTypeSlug)->first();
            $typeSectionScholarships = $type ? $type->scholarships()
                ->where('status', \App\Enums\ScholarshipStatus::ACTIVE)
                ->with(['countries', 'educationLevels'])
                ->latest() // Or orderBy views_count if available
                ->take(3)
                ->get() : collect();
        } else {
            $typeSectionScholarships = $featuredScholarships->skip(1)->take(3);
        }

        // Calculate Field Section Scholarships
        if ($this->selectedFieldSlug) {
            $field = \App\Models\FieldOfStudy::where('slug', $this->selectedFieldSlug)->first();
            $fieldSectionScholarships = $field ? $field->scholarships()
                ->where('status', \App\Enums\ScholarshipStatus::ACTIVE)
                ->with(['countries', 'educationLevels'])
                ->latest()
                ->take(4)
                ->get() : collect();
        } else {
            $fieldSectionScholarships = $latestScholarships->take(4);
        }

        // Calculate Level Section Scholarships
        if ($this->selectedLevelSlug) {
            $level = \App\Models\EducationLevel::where('slug', $this->selectedLevelSlug)->first();
            $levelSectionScholarships = $level ? $level->scholarships()
                ->where('status', \App\Enums\ScholarshipStatus::ACTIVE)
                ->with(['countries', 'educationLevels'])
                ->latest()
                ->take(3)
                ->get() : collect();
        } else {
            $levelSectionScholarships = $featuredScholarships->skip(2)->take(3);
        }

        // Popular filters based on views
        $popularCountries = \App\Models\Country::whereHas('scholarships', function ($q) {
            $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
        })
            ->withSum(['scholarships' => function ($q) {
                $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
            }], 'views_count')
            ->orderBy('scholarships_sum_views_count', 'desc')
            ->take(3)
            ->get();

        $popularLevels = \App\Models\EducationLevel::whereHas('scholarships', function ($q) {
            $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
        })
            ->withSum(['scholarships' => function ($q) {
                $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
            }], 'views_count')
            ->orderBy('scholarships_sum_views_count', 'desc')
            ->take(3)
            ->get();

        $popularTypes = \App\Models\ScholarshipType::whereHas('scholarships', function ($q) {
            $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
        })
            ->withSum(['scholarships' => function ($q) {
                $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
            }], 'views_count')
            ->orderBy('scholarships_sum_views_count', 'desc')
            ->take(3)
            ->get();

        $countries = \App\Models\Country::whereHas('scholarships', function ($q) {
            $q->where('status', \App\Enums\ScholarshipStatus::ACTIVE);
        })->get();

        $scholarshipTypes = \App\Models\ScholarshipType::all();
        $fieldsOfStudy = \App\Models\FieldOfStudy::whereNull('parent_id')->get();
        $educationLevels = \App\Models\EducationLevel::all();

        // Fetch Success Stories
        $testimonials = \App\Models\SuccessStory::approved()
            ->featured()
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.pages.home', [
            'premiumScholarships' => $premiumScholarships,
            'featuredScholarships' => $featuredScholarships,
            'typeSectionScholarships' => $typeSectionScholarships,
            'fieldSectionScholarships' => $fieldSectionScholarships,
            'levelSectionScholarships' => $levelSectionScholarships,
            'latestScholarships' => $latestScholarships,
            'latestPosts' => $latestPosts,
            'countries' => $countries,
            'scholarshipTypes' => $scholarshipTypes,
            'fieldsOfStudy' => $fieldsOfStudy,
            'educationLevels' => $educationLevels,
            'popularCountries' => $popularCountries,
            'popularLevels' => $popularLevels,
            'popularTypes' => $popularTypes,
            'similarScholarships' => $featuredScholarships, // Temporary placeholder for read next
            'testimonials' => $testimonials,
        ]);
    }
}

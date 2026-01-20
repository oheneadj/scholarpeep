<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use App\Models\ScholarshipType;
use Livewire\Component;
use Livewire\Attributes\Url;

class ScholarshipFilters extends Component
{
    public $showSaveModal = false;
    public $searchName = '';

    #[Url(as: 'q')]
    public $search = '';

    #[Url(as: 'country')]
    public $selectedCountries = [];

    #[Url(as: 'level')]
    public $selectedLevels = [];

    #[Url(as: 'field')]
    public $selectedFields = [];

    #[Url(as: 'award_min')]
    public $awardMin = 0;

    #[Url(as: 'award_max')]
    public $awardMax = 100000;

    #[Url(as: 'types')]
    public $selectedTypes = [];

    public function updated()
    {
        $this->dispatch('filters-updated', filters: [
            'search' => $this->search,
            'selectedCountries' => $this->selectedCountries,
            'selectedLevels' => $this->selectedLevels,
            'selectedFields' => $this->selectedFields,
            'awardMin' => $this->awardMin,
            'awardMax' => $this->awardMax,
            'selectedTypes' => $this->selectedTypes,
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'selectedCountries', 'selectedLevels', 'selectedFields', 'awardMin', 'awardMax', 'selectedTypes']);
        $this->updated();
    }

    public function saveSearch()
    {
        $this->validate([
            'searchName' => 'required|min:3|max:50'
        ]);

        \App\Models\SavedSearch::create([
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'name' => $this->searchName,
            'filters' => [
                'search' => $this->search,
                'selectedCountries' => $this->selectedCountries,
                'selectedLevels' => $this->selectedLevels,
                'selectedFields' => $this->selectedFields,
                'awardMin' => $this->awardMin,
                'awardMax' => $this->awardMax,
                'selectedTypes' => $this->selectedTypes,
            ],
        ]);

        $this->showSaveModal = false;
        $this->searchName = '';
        $this->dispatch('notify', message: 'Search saved successfully!');
    }

    public function render()
    {
        return view('livewire.scholarship-filters', [
            'countries' => Country::orderBy('name', 'asc')->get(),
            'educationLevels' => EducationLevel::orderBy('name', 'asc')->get(),
            'fieldsOfStudy' => FieldOfStudy::whereNull('parent_id')
                ->with('children')
                ->orderBy('name', 'asc')
                ->get(),
            'scholarshipTypes' => ScholarshipType::all(),
        ]);
    }
}

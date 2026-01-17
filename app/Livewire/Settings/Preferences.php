<?php

namespace App\Livewire\Settings;

use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use App\Models\ScholarshipType;
use App\Models\TenantPreference;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.dashboard')]
class Preferences extends Component
{
    public array $preferred_countries = [];
    public array $preferred_education_levels = [];
    public array $preferred_fields_of_study = [];
    public array $preferred_scholarship_types = [];

    public function mount()
    {
        $user = Auth::user();
        $preferences = $user->preference ?? new TenantPreference(['user_id' => $user->id]);

        $this->preferred_countries = $preferences->preferred_countries ?? [];
        $this->preferred_education_levels = $preferences->preferred_education_levels ?? [];
        $this->preferred_fields_of_study = $preferences->preferred_fields_of_study ?? [];
        $this->preferred_scholarship_types = $preferences->preferred_scholarship_types ?? [];
    }

    public function savePreferences()
    {
        $user = Auth::user();
        
        $preferences = TenantPreference::updateOrCreate(
            ['user_id' => $user->id],
            [
                'preferred_countries' => $this->preferred_countries,
                'preferred_education_levels' => $this->preferred_education_levels,
                'preferred_fields_of_study' => $this->preferred_fields_of_study,
                'preferred_scholarship_types' => $this->preferred_scholarship_types,
            ]
        );

        $this->dispatch('notify', message: 'Match preferences updated!');
    }

    public function render()
    {
        return view('livewire.settings.preferences', [
            'countries' => Country::orderBy('name')->get(),
            'levels' => EducationLevel::all(),
            'fields' => FieldOfStudy::whereNull('parent_id')->with('children')->get(),
            'types' => ScholarshipType::all(),
        ]);
    }
}

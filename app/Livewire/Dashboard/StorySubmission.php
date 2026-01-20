<?php

namespace App\Livewire\Dashboard;

use App\Models\Scholarship;
use App\Models\SuccessStory;
use App\Models\SavedScholarship;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard')]
class StorySubmission extends Component
{
    use WithFileUploads;

    public $title;
    public $story;
    public $scholarship_id;
    public $university;
    public $country;
    public $student_photo;

    // Searchable dropdown state
    public $countrySearch = '';
    public $universitySearch = '';
    public $showCountryResults = false;
    public $showUniversityResults = false;

    public function mount()
    {
        $this->student_name = Auth::user()->name;
    }

    protected $rules = [
        'title' => 'required|min:5|max:255',
        'story' => 'required|min:50',
        'scholarship_id' => 'nullable|exists:scholarships,id',
        'university' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'student_photo' => 'nullable|image|max:1024',
    ];

    public function selectCountry($name)
    {
        $this->country = $name;
        $this->countrySearch = $name;
        $this->showCountryResults = false;
    }

    public function selectUniversity($name)
    {
        $this->university = $name;
        $this->universitySearch = $name;
        $this->showUniversityResults = false;
    }

    public function updatedCountrySearch()
    {
        $this->showCountryResults = strlen($this->countrySearch) >= 2;
    }

    public function updatedUniversitySearch()
    {
        $this->showUniversityResults = strlen($this->universitySearch) >= 2;
    }

    public function submit()
    {
        $this->validate();

        $photoPath = null;
        if ($this->student_photo) {
            $photoPath = $this->student_photo->store('success-stories', 'public');
        }

        SuccessStory::create([
            'user_id' => Auth::id(),
            'scholarship_id' => $this->scholarship_id,
            'title' => $this->title,
            'story' => $this->story,
            'student_name' => Auth::user()->name,
            'student_photo' => $photoPath,
            'university' => $this->university,
            'country' => $this->country,
            'is_approved' => false,
            'is_featured' => false,
        ]);

        $this->reset(['title', 'story', 'scholarship_id', 'university', 'country', 'student_photo', 'countrySearch', 'universitySearch']);
        
        $this->dispatch('notify', message: 'We have received your story and are glad to have it. It will be accessible once it passes our verification. We will get back to you.');
        
        return redirect()->route('dashboard');
    }

    public function render()
    {
        $savedScholarships = SavedScholarship::where('user_id', '=', Auth::id(), 'and')
            ->whereIn('status', ['accepted', 'applied'])
            ->with('scholarship')
            ->get();

        $countries = [];
        if ($this->showCountryResults) {
            $countries = \App\Models\Country::where('name', 'like', '%' . $this->countrySearch . '%', 'and')
                ->limit(5)
                ->get();
        }

        $universities = [];
        if ($this->showUniversityResults) {
            // Suggest from existing stories or scholarships
            $universities = Scholarship::where('provider_name', 'like', '%' . $this->universitySearch . '%', 'and')
                ->distinct()
                ->limit(5)
                ->pluck('provider_name');
                
            if ($universities->isEmpty()) {
                $universities = SuccessStory::where('university', 'like', '%' . $this->universitySearch . '%', 'and')
                    ->distinct()
                    ->limit(5)
                    ->pluck('university');
            }
        }

        return view('livewire.dashboard.story-submission', [
            'savedScholarships' => $savedScholarships,
            'countries' => $countries,
            'universities' => $universities,
        ]);
    }
}

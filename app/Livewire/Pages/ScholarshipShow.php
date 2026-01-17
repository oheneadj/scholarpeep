<?php

namespace App\Livewire\Pages;

use App\Models\Scholarship;
use App\Models\ScholarshipView;
use App\Models\AffiliateClick;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\RateLimiter;

#[Layout('layouts.frontend')]
class ScholarshipShow extends Component
{
    public Scholarship $scholarship;
    public bool $isSaved = false;

    public function mount(Scholarship $scholarship)
    {
        if ($this->scholarship->status !== \App\Enums\ScholarshipStatus::ACTIVE) {
            abort(404);
        }

        $this->scholarship->load(['countries', 'educationLevels', 'fieldsOfStudy', 'scholarshipTypes', 'deadlines', 'requirements']);

        if (auth()->check()) {
            $this->isSaved = auth()->user()->savedScholarships()
                ->where('scholarship_id', $this->scholarship->id)
                ->exists();
        }

        $this->trackView();
        $this->addToRecentlyViewed();
    }

    protected function trackView()
    {
        ScholarshipView::create([
            'scholarship_id' => $this->scholarship->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
        ]);

        $this->scholarship->increment('views_count');
    }

    protected function addToRecentlyViewed()
    {
        $recent = session()->get('recently_viewed_scholarships', []);

        // Remove if exists to move to top
        if (($key = array_search($this->scholarship->id, $recent)) !== false) {
            unset($recent[$key]);
        }

        array_unshift($recent, $this->scholarship->id);
        $recent = array_slice($recent, 0, 10);

        session()->put('recently_viewed_scholarships', $recent);
    }

    public function toggleSave()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        $key = 'save-scholarship:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            $this->dispatch('notify', message: "Too many requests. Please wait $seconds seconds.");
            return;
        }

        RateLimiter::hit($key);

        $saved = $user->savedScholarships()
            ->where('scholarship_id', $this->scholarship->id)
            ->first();

        if ($saved) {
            $saved->delete();
            $this->isSaved = false;
            $this->dispatch('notify', message: 'Scholarship removed from saved.');
        } else {
            $user->savedScholarships()->create([
                'scholarship_id' => $this->scholarship->id,
                'status' => \App\Enums\ApplicationStatus::SAVED,
            ]);
            $this->isSaved = true;
            $this->dispatch('notify', message: 'Scholarship saved to dashboard!');
        }
    }

    public function apply()
    {
        AffiliateClick::create([
            'scholarship_id' => $this->scholarship->id,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
        ]);

        $this->scholarship->increment('clicks_count');

        return redirect()->away($this->scholarship->application_url);
    }

    public function render()
    {
        // Get related scholarships based on multiple criteria
        $similarScholarships = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->where('id', '!=', $this->scholarship->id)
            ->where(function ($query) {
                // Match by scholarship type
                $query->whereHas('scholarshipTypes', function ($q) {
                    $q->whereIn('scholarship_types.id', $this->scholarship->scholarshipTypes->pluck('id'));
                })
                // OR match by country
                ->orWhereHas('countries', function ($q) {
                    $q->whereIn('countries.id', $this->scholarship->countries->pluck('id'));
                })
                // OR match by education level
                ->orWhereHas('educationLevels', function ($q) {
                    $q->whereIn('education_levels.id', $this->scholarship->educationLevels->pluck('id'));
                });
            })
            ->with(['countries', 'educationLevels', 'scholarshipTypes'])
            ->latest()
            ->take(6)
            ->get();

        $featuredScholarships = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->where('id', '!=', $this->scholarship->id)
            ->where('sponsorship_tier', \App\Enums\SponsorshipTier::FEATURED)
            ->latest()
            ->take(3)
            ->get();

        $featuredPosts = \App\Models\BlogPost::where('status', 'published')
            ->where('is_featured', true)
            ->latest()
            ->take(5)
            ->get();

        $popularPosts = \App\Models\BlogPost::published()
            ->orderBy('views_count', 'desc')
            ->take(4)
            ->get();

        $topics = \App\Models\ScholarshipType::all();

        return view('livewire.pages.scholarship-show', [
            'similarScholarships' => $similarScholarships,
            'featuredScholarships' => $featuredScholarships,
            'featuredPosts' => $featuredPosts,
            'popularPosts' => $popularPosts,
            'topics' => $topics,
        ]);
    }
}

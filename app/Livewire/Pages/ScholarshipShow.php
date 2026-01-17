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

    protected function applyCurrentScholarshipMatching($query)
    {
        $query->where(function ($q) {
            // Match by scholarship type
            $q->whereHas('scholarshipTypes', function ($typeQuery) {
                $typeQuery->whereIn('scholarship_types.id', $this->scholarship->scholarshipTypes->pluck('id'));
            })
            // OR match by country
            ->orWhereHas('countries', function ($countryQuery) {
                $countryQuery->whereIn('countries.id', $this->scholarship->countries->pluck('id'));
            })
            // OR match by education level
            ->orWhereHas('educationLevels', function ($levelQuery) {
                $levelQuery->whereIn('education_levels.id', $this->scholarship->educationLevels->pluck('id'));
            });
        });
    }

    public function render()
    {
        // Build related scholarships query with smart matching
        $query = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
            ->where('id', '!=', $this->scholarship->id);

        // If user is logged in, exclude already saved scholarships and use preferences
        if (auth()->check()) {
            $user = auth()->user();
            
            // Exclude saved scholarships
            $savedScholarshipIds = $user->savedScholarships()->pluck('scholarship_id');
            $query->whereNotIn('id', $savedScholarshipIds);

            // Load user preferences
            $preferences = $user->preferences;
            
            if ($preferences) {
                // Match by user's preferred countries, education levels, fields, or types
                $query->where(function ($q) use ($preferences) {
                    if ($preferences->country_ids && count($preferences->country_ids) > 0) {
                        $q->orWhereHas('countries', function ($countryQuery) use ($preferences) {
                            $countryQuery->whereIn('countries.id', $preferences->country_ids);
                        });
                    }
                    
                    if ($preferences->education_level_ids && count($preferences->education_level_ids) > 0) {
                        $q->orWhereHas('educationLevels', function ($levelQuery) use ($preferences) {
                            $levelQuery->whereIn('education_levels.id', $preferences->education_level_ids);
                        });
                    }
                    
                    if ($preferences->field_of_study_ids && count($preferences->field_of_study_ids) > 0) {
                        $q->orWhereHas('fieldsOfStudy', function ($fieldQuery) use ($preferences) {
                            $fieldQuery->whereIn('fields_of_study.id', $preferences->field_of_study_ids);
                        });
                    }
                    
                    if ($preferences->scholarship_type_ids && count($preferences->scholarship_type_ids) > 0) {
                        $q->orWhereHas('scholarshipTypes', function ($typeQuery) use ($preferences) {
                            $typeQuery->whereIn('scholarship_types.id', $preferences->scholarship_type_ids);
                        });
                    }
                });
            } else {
                // Fallback to current scholarship's attributes if no preferences
                $this->applyCurrentScholarshipMatching($query);
            }
        } else {
            // For non-logged-in users, match by current scholarship's attributes
            $this->applyCurrentScholarshipMatching($query);
        }

        $similarScholarships = $query
            ->with(['countries', 'educationLevels', 'scholarshipTypes'])
            ->orderByDesc('created_at') // Priority to new scholarships
            ->orderByDesc('views_count') // Then by most viewed
            ->take(3)
            ->get();

        // If we don't have 3 scholarships, fill with most viewed (excluding current and saved)
        if ($similarScholarships->count() < 3) {
            $excludeIds = $similarScholarships->pluck('id')->push($this->scholarship->id)->toArray();
            
            if (auth()->check()) {
                $savedIds = auth()->user()->savedScholarships()->pluck('scholarship_id')->toArray();
                $excludeIds = array_merge($excludeIds, $savedIds);
            }
            
            $fillScholarships = Scholarship::where('status', \App\Enums\ScholarshipStatus::ACTIVE)
                ->whereNotIn('id', $excludeIds)
                ->with(['countries', 'educationLevels', 'scholarshipTypes'])
                ->orderByDesc('created_at')
                ->orderByDesc('views_count')
                ->take(3 - $similarScholarships->count())
                ->get();
            
            $similarScholarships = $similarScholarships->merge($fillScholarships);
        }

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

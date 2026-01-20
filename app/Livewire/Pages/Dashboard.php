<?php

namespace App\Livewire\Pages;

use App\Models\SavedScholarship;
use App\Enums\ApplicationStatus;
use App\Services\ScholarshipMatcher;
use App\Services\PointService;
use App\Services\BadgeService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Dashboard extends Component
{
    use WithPagination;

    protected $listeners = ['status-updated' => '$refresh'];

    public ?int $selectedSavedId = null;

    // Filtering & Sorting
    public string $search = '';
    public string $statusFilter = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Bulk Actions
    public array $selectedSavedIds = [];
    public bool $selectAll = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedSavedIds = auth()->user()->savedScholarships()
                ->pluck('id')
                ->map(fn($id) => (string) $id)
                ->toArray();
        } else {
            $this->selectedSavedIds = [];
        }
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function bulkDelete(): void
    {
        auth()->user()->savedScholarships()
            ->whereIn('id', $this->selectedSavedIds)
            ->delete();

        $this->selectedSavedIds = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', message: 'Selected scholarships removed.');
    }

    public function bulkUpdateStatus(string $status): void
    {
        auth()->user()->savedScholarships()
            ->whereIn('id', $this->selectedSavedIds)
            ->update(['status' => ApplicationStatus::from($status)]);

        $this->selectedSavedIds = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', message: 'Status updated for selected scholarships.');
    }

    public function showTracker(int $id): void
    {
        $this->selectedSavedId = $id;
        $this->dispatch('open-tracker');
    }

    public ?int $deleteId = null;

    // ... existing code ...

    public function deleteSaved(?int $id = null): void
    {
        $id = $id ?? $this->deleteId;
        
        if ($id) {
            \App\Models\SavedScholarship::where('user_id', '=', auth()->id(), 'and')
                ->where('id', '=', $id, 'and')
                ->delete();

            $this->dispatch('notify', message: 'Scholarship removed.');
            $this->deleteId = null;
        }
    }

    public function deleteSavedSearch(int $id): void
    {
        auth()->user()->savedSearches()->where('id', $id)->delete();
        $this->dispatch('notify', message: 'Saved search removed.');
    }

    public function updateStatus(int $id, string $status): void
    {
        // Use explicit query to satisfy linter
        \App\Models\SavedScholarship::where('user_id', '=', auth()->id(), 'and')
            ->where('id', '=', $id, 'and')
            ->update(['status' => $status]);
        $this->dispatch('notify', message: 'Status updated.');
    }



    public function render()
    {
        $query = auth()->user()->savedScholarships()
            ->with(['scholarship.countries'])
            ->leftJoin('scholarships', 'saved_scholarships.scholarship_id', '=', 'scholarships.id')
            ->select('saved_scholarships.*');

        // Apply Search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('scholarships.title', 'like', '%' . $this->search . '%')
                    ->orWhere('scholarships.provider_name', 'like', '%' . $this->search . '%');
            });
        }

        // Apply Status Filter
        if ($this->statusFilter) {
            $query->where('saved_scholarships.status', $this->statusFilter);
        }

        // Apply Sorting
        if ($this->sortField === 'deadline') {
            $query->orderBy('scholarships.primary_deadline', $this->sortDirection);
        } else {
            $query->orderBy('saved_scholarships.' . $this->sortField, $this->sortDirection);
        }

        $savedScholarships = $query->paginate(10);

        // Expanded Stats
        $expiringSoonCount = auth()->user()->savedScholarships()
            ->whereHas('scholarship', function($q) {
                $q->whereBetween('primary_deadline', [now(), now()->addDays(7)]);
            })->count();

        $totalPotentialAward = auth()->user()->savedScholarships()
            ->join('scholarships', 'saved_scholarships.scholarship_id', '=', 'scholarships.id')
            ->sum('scholarships.award_amount');

        $totalAppliedAward = auth()->user()->savedScholarships()
            ->applied()
            ->join('scholarships', 'saved_scholarships.scholarship_id', '=', 'scholarships.id')
            ->sum('scholarships.award_amount');

        $stats = [
            'saved' => auth()->user()->savedScholarships()->saved()->count(),
            'applied' => auth()->user()->savedScholarships()->applied()->count(),
            'pending' => auth()->user()->savedScholarships()->pending()->count(),
            'accepted' => auth()->user()->savedScholarships()->accepted()->count(),
            'expiring_soon' => $expiringSoonCount,
            'potential_award' => $totalPotentialAward,
            'applied_award' => $totalAppliedAward,
        ];

        // Recent Activity
        $recentActivity = auth()->user()->savedScholarships()
            ->with('scholarship')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Top Recommendations
        $preferences = auth()->user()->preference;
        $recommendedScholarships = collect();

        if ($preferences) {
            $recommendedScholarships = \App\Models\Scholarship::query()
                ->whereNotIn('id', auth()->user()->savedScholarships()->pluck('scholarship_id'))
                ->where(function ($q) use ($preferences) {
                    if ($preferences->preferred_countries) {
                        $q->orWhereHas('countries', fn($c) => $c->whereIn('id', $preferences->preferred_countries));
                    }
                    if ($preferences->preferred_education_levels) {
                        $q->orWhereIn('education_level_id', $preferences->preferred_education_levels); // Assumptions on schema
                    }
                    // Add more matching logic as needed based on actual schema
                })
                ->limit(3)
                ->get();
        }

        return view('livewire.pages.dashboard', [
            'savedScholarships' => $savedScholarships,
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'recommendedScholarships' => $recommendedScholarships,
            'hasPreferences' => (bool) $preferences,
            'pointsSummary' => app(PointService::class)->getUserPointsSummary(auth()->user()),
            'recentBadges' => app(BadgeService::class)->getEarnedBadges(auth()->user())->take(6),
            'savedSearches' => auth()->user()->savedSearches()->latest()->get(),
            'affiliateTools' => \App\Models\AffiliateTool::where('is_active', '=', true, 'and')->orderBy('sort_order', 'asc')->get(),
            'streakData' => [
                'current' => auth()->user()->login_streak,
                'next_milestone' => collect([7, 14, 30, 60, 90, 100])->first(fn($m) => $m > auth()->user()->login_streak) ?? 100,
                'days_left' => (collect([7, 14, 30, 60, 90, 100])->first(fn($m) => $m > auth()->user()->login_streak) ?? 100) - auth()->user()->login_streak,
            ],
        ]);
    }
}

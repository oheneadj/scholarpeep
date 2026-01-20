<?php

namespace App\Livewire\Pages;

use App\Models\SavedScholarship;
use App\Enums\ApplicationStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;

#[Layout('layouts.dashboard')]
class MyApplications extends Component
{
    use WithPagination;

    protected $listeners = ['status-updated' => '$refresh'];

    // Filtering & Sorting
    public string $search = '';
    public string $statusFilter = '';
    public string $deadlineFilter = ''; // 'upcoming', 'past', 'rolling'
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    // Bulk Actions
    public array $selectedSavedIds = [];
    public bool $selectAll = false;

    // Modals
    public ?int $selectedSavedId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'deadlineFilter' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedDeadlineFilter(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $query = $this->buildQuery();
            $this->selectedSavedIds = $query->pluck('saved_scholarships.id')
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
        \App\Models\SavedScholarship::where('user_id', '=', auth()->id(), 'and')
            ->whereIn('id', $this->selectedSavedIds)
            ->delete();

        $this->selectedSavedIds = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', message: 'Selected scholarships removed.');
    }

    public function bulkUpdateStatus(string $status): void
    {
        \App\Models\SavedScholarship::where('user_id', '=', auth()->id(), 'and')
            ->whereIn('id', $this->selectedSavedIds)
            ->update(['status' => $status]);

        $this->selectedSavedIds = [];
        $this->selectAll = false;
        
        $this->dispatch('notify', message: 'Status updated for selected scholarships.');
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

    public function showTracker(int $id): void
    {
        $this->selectedSavedId = $id;
        $this->dispatch('open-tracker');
    }

    protected function buildQuery(): \Illuminate\Database\Eloquent\Relations\HasMany|Builder
    {
        $query = auth()->user()->savedScholarships()
            ->with(['scholarship.countries'])
            ->join('scholarships', 'saved_scholarships.scholarship_id', '=', 'scholarships.id')
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

        // Apply Deadline Filter
        if ($this->deadlineFilter === 'upcoming') {
            $query->where('scholarships.primary_deadline', '>=', now());
        } elseif ($this->deadlineFilter === 'past') {
            $query->where('scholarships.primary_deadline', '<', now());
        } elseif ($this->deadlineFilter === 'rolling') {
            $query->whereNull('scholarships.primary_deadline');
        }

        // Apply Sorting
        if ($this->sortField === 'deadline') {
            $query->orderBy('scholarships.primary_deadline', $this->sortDirection);
        } elseif ($this->sortField === 'award_amount') {
            $query->orderBy('scholarships.award_amount', $this->sortDirection);
        } else {
            $escapedField = 'saved_scholarships.' . $this->sortField;
            if ($this->sortField === 'created_at' || $this->sortField === 'updated_at') {
                 // Disambiguate common fields
                $query->orderBy($escapedField, $this->sortDirection);
            } else {
                 $query->orderBy($escapedField, $this->sortDirection);
            }
        }

        return $query;
    }

    public function getStatusCountsProperty()
    {
        $counts = \App\Models\SavedScholarship::where('user_id', auth()->id())
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Ensure all statuses have a default of 0
        $allStatuses = array_column(ApplicationStatus::cases(), 'value');
        $defaults = array_fill_keys($allStatuses, 0);

        return array_merge($defaults, $counts);
    }

    public function render()
    {
        $savedScholarships = $this->buildQuery()->paginate(15);

        return view('livewire.pages.my-applications', [
            'savedScholarships' => $savedScholarships,
            'statusCounts' => $this->statusCounts,
        ]);
    }
}

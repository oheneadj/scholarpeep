<?php

namespace App\Livewire\Pages;

use App\Models\SavedScholarship;
use App\Enums\ApplicationStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.dashboard')]
class Dashboard extends Component
{
    use WithPagination;

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

    public function deleteSaved(int $id): void
    {
        auth()->user()->savedScholarships()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Scholarship removed.');
    }

    public function updateStatus(int $id, string $status): void
    {
        $saved = auth()->user()->savedScholarships()->findOrFail($id);
        $saved->update(['status' => ApplicationStatus::from($status)]);
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

        $stats = [
            'saved' => auth()->user()->savedScholarships()->saved()->count(),
            'applied' => auth()->user()->savedScholarships()->applied()->count(),
            'pending' => auth()->user()->savedScholarships()->pending()->count(),
            'accepted' => auth()->user()->savedScholarships()->accepted()->count(),
        ];

        return view('livewire.pages.dashboard', [
            'savedScholarships' => $savedScholarships,
            'stats' => $stats,
        ]);
    }
}

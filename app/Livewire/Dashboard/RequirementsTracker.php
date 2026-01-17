<?php

namespace App\Livewire\Dashboard;

use App\Models\SavedScholarship;
use App\Models\SavedScholarshipRequirement;
use Livewire\Component;
use Illuminate\Support\Collection;

class RequirementsTracker extends Component
{
    public int $savedScholarshipId;
    public int $editingRequirementId = 0;
    public string $currentNote = '';

    public function mount(int $savedScholarshipId): void
    {
        $this->savedScholarshipId = $savedScholarshipId;
    }

    public function getSavedScholarshipProperty(): ?SavedScholarship
    {
        return SavedScholarship::with(['scholarship.requirements', 'requirementProgress'])
            ->find($this->savedScholarshipId);
    }

    public function getRequirementsListProperty(): Collection
    {
        $saved = $this->savedScholarship;
        
        if (!$saved) {
            return collect();
        }

        $allRequirements = $saved->scholarship->requirements;
        $progressMap = $saved->requirementProgress()
            ->get()
            ->keyBy('scholarship_requirement_id');

        return $allRequirements->map(function ($req) use ($progressMap) {
            $progress = $progressMap->get($req->id);
            return [
                'id' => $req->id,
                'title' => $req->title,
                'type' => $req->type,
                'is_required' => $req->is_required,
                'completed' => $progress?->is_completed ?? false,
                'notes' => $progress?->notes ?? '',
            ];
        });
    }

    public function getProgressProperty(): int
    {
        $requirements = $this->requirementsList;
        
        if ($requirements->isEmpty()) {
            return 100;
        }

        $completedCount = $requirements->where('completed', true)->count();
        
        return (int) round(($completedCount / $requirements->count()) * 100);
    }

    public function toggleRequirement(int $requirementId): void
    {
        $saved = $this->savedScholarship;
        
        if (!$saved) {
            return;
        }

        $progress = $saved->requirementProgress()
            ->firstOrNew(['scholarship_requirement_id' => $requirementId]);

        $progress->is_completed = !$progress->is_completed;
        $progress->completed_at = $progress->is_completed ? now() : null;
        $progress->save();

        $this->dispatch('requirement-updated');
    }

    public function editNote(int $requirementId): void
    {
        $this->editingRequirementId = $requirementId;
        
        $requirement = $this->requirementsList->firstWhere('id', $requirementId);
        $this->currentNote = $requirement['notes'] ?? '';
    }

    public function saveNote(): void
    {
        if (!$this->editingRequirementId) {
            return;
        }

        $saved = $this->savedScholarship;
        
        if (!$saved) {
            return;
        }

        $progress = $saved->requirementProgress()
            ->firstOrNew(['scholarship_requirement_id' => $this->editingRequirementId]);

        $progress->notes = $this->currentNote;
        $progress->save();

        $this->editingRequirementId = 0;
        $this->currentNote = '';
        
        $this->dispatch('requirement-updated');
    }

    public function cancelEditNote(): void
    {
        $this->editingRequirementId = 0;
        $this->currentNote = '';
    }

    public function render()
    {
        return view('livewire.dashboard.requirements-tracker', [
            'requirements' => $this->requirementsList,
            'progress' => $this->progress,
            'savedScholarship' => $this->savedScholarship,
        ]);
    }
}

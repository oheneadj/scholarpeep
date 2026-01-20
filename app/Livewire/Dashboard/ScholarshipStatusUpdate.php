<?php

namespace App\Livewire\Dashboard;

use App\Models\SavedScholarship;
use App\Enums\ApplicationStatus;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ScholarshipStatusUpdate extends Component
{
    public $savedScholarshipId;
    public $status;
    public $notes;
    public $appliedAt;

    protected $listeners = ['open-status-update' => 'loadScholarship'];

    public function loadScholarship($id)
    {
        $saved = Auth::user()->savedScholarships()->findOrFail($id);
        $this->savedScholarshipId = $id;
        $this->status = $saved->status->value;
        $this->notes = $saved->notes;
        $this->appliedAt = $saved->applied_at?->format('Y-m-d');
        
        $this->dispatch('status-update-loaded');
    }

    public function updateStatus()
    {
        $saved = Auth::user()->savedScholarships()->with('scholarship.deadlines')->findOrFail($this->savedScholarshipId);
        
        $oldStatus = $saved->status;
        $saved->status = ApplicationStatus::from($this->status);
        $saved->notes = $this->notes;
        $saved->applied_at = $this->appliedAt ? \Carbon\Carbon::parse($this->appliedAt) : null;
        $saved->save();

        // Sync to Google Calendar if status changed to Applied and user has token
        if ($saved->status === ApplicationStatus::APPLIED && $oldStatus !== ApplicationStatus::APPLIED) {
            $user = Auth::user();
            if ($user->google_calendar_token) {
                $calendarService = app(\App\Services\GoogleCalendarService::class);
                $primaryDeadline = $saved->scholarship->primary_deadline;
                
                if ($primaryDeadline) {
                    $eventLink = $calendarService->createDeadlineEvent($user, $saved->scholarship, $primaryDeadline);
                    if ($eventLink) {
                        $saved->update(['google_event_id' => $eventLink]);
                    }
                }
            }
        }

        $this->dispatch('notify', message: 'Application status updated successfully!');
        $this->dispatch('status-updated');
        $this->dispatch('close-modal', id: 'status-update-modal');
    }

    public function getStatusDescription($status)
    {
        return match ($status) {
            'saved' => 'Interested in this scholarship.',
            'pending' => 'Working on the application.',
            'applied' => 'Formally submitted application.',
            'accepted' => 'Congratulations! You won.',
            'rejected' => 'Try again next time.',
            default => '',
        };
    }

    public function render()
    {
        return view('livewire.dashboard.scholarship-status-update');
    }
}

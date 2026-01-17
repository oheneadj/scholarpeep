<?php

namespace App\Livewire\Traits;

use App\Models\SavedScholarship;
use Illuminate\Support\Facades\Auth;

trait CanSaveScholarship
{
    public $savedScholarshipIds = [];

    public function mountCanSaveScholarship()
    {
        if (Auth::check()) {
            $this->savedScholarshipIds = SavedScholarship::where('user_id', Auth::id())
                ->where('status', \App\Enums\ApplicationStatus::SAVED)
                ->pluck('scholarship_id')
                ->toArray();
        }
    }

    public function toggleSave($scholarshipId)
    {
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();
        $saved = SavedScholarship::where('user_id', $userId)
            ->where('scholarship_id', $scholarshipId)
            ->first();

        if ($saved) {
            // If it's already saved, we might want to toggle it off (delete or change status)
            // For simple "Save/Unsave", we typically delete or toggle status.
            // Assuming we want to keep history or status, let's toggle status or delete.
            // If the user has applied, we probably shouldn't "unsave" it to "saved", but remove it?
            // For simplicity and typical "bookmark" behavior:
            if ($saved->status === \App\Enums\ApplicationStatus::SAVED) {
                $saved->delete(); // Or set status to something else if soft delete? 
                // Let's assume physical delete for "unsaving" a pure bookmark.
                $this->savedScholarshipIds = array_diff($this->savedScholarshipIds, [$scholarshipId]);
            } else {
                // If application is in progress, typically we don't "unsave" via bookmark button?
                // Or maybe bookmark button only reflects "SAVED" status?
                // Let's assume bookmark button toggles SAVED state. 
                // If it exists but not SAVED (e.g. APPLIED), maybe we shouldn't touch it via this simple button?
                // Or maybe we treat it as "Is it on my list?".
                
                // Refined logic: If entry exists, remove it (providing it's just a save). 
                // If it's an application, we might want to warn?
                // For now, let's stick to simple toggle for SAVED status.
                $saved->delete(); 
                $this->savedScholarshipIds = array_diff($this->savedScholarshipIds, [$scholarshipId]);
            }
        } else {
            SavedScholarship::create([
                'user_id' => $userId,
                'scholarship_id' => $scholarshipId,
                'status' => \App\Enums\ApplicationStatus::SAVED,
            ]);
            $this->savedScholarshipIds[] = $scholarshipId;
        }
    }
}

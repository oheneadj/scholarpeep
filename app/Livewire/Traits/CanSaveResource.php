<?php

namespace App\Livewire\Traits;

use App\Models\SavedResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

trait CanSaveResource
{
    public $savedResourceIds = [];

    public function mountCanSaveResource()
    {
        if (Auth::check()) {
            $this->savedResourceIds = SavedResource::where('user_id', '=', Auth::id(), 'and')
                ->pluck('resource_id')
                ->toArray();
        }
    }

    public function toggleSave($resourceId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'));
        }

        $user = Auth::user();
        $key = 'save-resource:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 10)) {
            $seconds = RateLimiter::availableIn($key);
            $this->dispatch('notify', message: "Too many requests. Please wait $seconds seconds.");
            return;
        }

        RateLimiter::hit($key);

        $saved = SavedResource::where('user_id', '=', $user->id, 'and')
            ->where('resource_id', '=', $resourceId, 'and')
            ->first();

        if ($saved) {
            $saved->delete();
            $this->savedResourceIds = array_diff($this->savedResourceIds, [$resourceId]);
            $this->dispatch('notify', message: 'Resource removed from saved.');
        } else {
            SavedResource::create([
                'user_id' => $user->id,
                'resource_id' => $resourceId,
            ]);
            $this->savedResourceIds[] = $resourceId;
            $this->dispatch('notify', message: 'Resource saved successfully!');
        }
        
        // Emit an event in case other components need to refresh
        $this->dispatch('resource-saved-toggled', resourceId: $resourceId);
    }
}

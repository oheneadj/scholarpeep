<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ConnectedAccounts extends Component
{
    public function render()
    {
        return view('livewire.settings.connected-accounts', [
            'user' => Auth::user(),
        ]);
    }
    
    public function disconnectGoogle()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update(['google_calendar_token' => null]);
        $this->dispatch('notify', message: 'Google Calendar disconnected.');
    }
}

<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        // Optional: verify user needs migration, though middleware handles protection
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
        ]);

        $user = Auth::user();
        
        $user->forceFill([
            'password' => Hash::make($this->password),
            'must_reset_password' => false,
        ])->save();

        session()->flash('status', 'password-updated');
        
        return redirect()->intended();
    }

    public function render()
    {
        return view('livewire.auth.change-password')
            ->layout('layouts.auth');
    }
}

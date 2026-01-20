<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->scopes(['https://www.googleapis.com/auth/calendar.events'])
            ->with(['access_type' => 'offline', 'prompt' => 'consent select_account'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = Auth::user();

            // Store the token in the user's record (assuming we add a column or use a settings table)
            // For now, we'll assume a simplifed approach or just use the session if it's transient,
            // but for "offline" access we usually need to store the refresh token.
            
            // Let's store it in a JSON column 'settings' or similar if User has it, 
            // or create a new migration for google_access_token json column.
            
            // Checking User model for best place... 
            // We will update the User model to cast 'google_calendar_token' as array/json
            
            $user->update([
                'google_calendar_token' => [
                    'access_token' => $googleUser->token,
                    'refresh_token' => $googleUser->refreshToken,
                    'expires_in' => $googleUser->expiresIn,
                    'created' => now()->timestamp,
                ]
            ]);

            return redirect()->route('dashboard')->with('success', 'Google Calendar connected!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Failed to connect Google Calendar.');
        }
    }
}

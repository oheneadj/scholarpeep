<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect to the provider.
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the provider callback.
     */
    public function callback(string $provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Authentication failed.');
        }

        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Update provider ID if missing (or keep as is)
            Auth::login($user);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Scholar',
                'email' => $socialUser->getEmail(),
                'password' => Hash::make(Str::random(24)),
                'email_verified_at' => now(),
            ]);

            Auth::login($user);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
}

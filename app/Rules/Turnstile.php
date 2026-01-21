<?php

namespace App\Rules;

use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Turnstile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $settings = app(GeneralSettings::class);
        $secretKey = $settings->turnstile_secret_key;

        if (empty($secretKey)) {
            // If verification is not configured, we can skip validation or fail safely.
            // For security, it might be better to log a warning and allow locally or fail in production.
            // Here we'll skip if no key is set, assuming setup is incomplete.
            return;
        }

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => $secretKey,
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        if (! $response->json('success')) {
            $fail('The :attribute verification failed. Please try again.');
        }
    }
}

<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?string $turnstile_site_key;
    public ?string $turnstile_secret_key;

    public static function group(): string
    {
        return 'general';
    }
}

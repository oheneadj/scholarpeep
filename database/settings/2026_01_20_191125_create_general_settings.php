<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.turnstile_site_key', null);
        $this->migrator->add('general.turnstile_secret_key', null);
    }
};

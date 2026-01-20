<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('seo.site_name', 'Scholarpeep');
        $this->migrator->add('seo.site_description', 'Your gateway to global scholarship opportunities and education resources.');
        $this->migrator->add('seo.site_logo', null);
        $this->migrator->add('seo.og_image', null);
        $this->migrator->add('seo.twitter_handle', '@scholarpeep');
        $this->migrator->add('seo.facebook_url', '#');
        $this->migrator->add('seo.instagram_url', '#');
        $this->migrator->add('seo.linkedin_url', '#');
        $this->migrator->add('seo.twitter_url', '#');
        $this->migrator->add('seo.google_analytics_id', null);
        $this->migrator->add('seo.plausible_domain', null);
    }
};

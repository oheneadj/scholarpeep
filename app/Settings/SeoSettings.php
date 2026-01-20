<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SeoSettings extends Settings
{
    public string $site_name;
    public string $site_description;
    public ?string $site_logo;
    public ?string $og_image;
    public ?string $twitter_handle;
    public ?string $facebook_url;
    public ?string $instagram_url;
    public ?string $linkedin_url;
    public ?string $twitter_url;
    public ?string $google_analytics_id;
    public ?string $plausible_domain;

    // Static Pages
    public ?string $home_title;
    public ?string $home_description;
    
    public ?string $scholarships_title;
    public ?string $scholarships_description;
    
    public ?string $blog_title;
    public ?string $blog_description;
    
    public ?string $resources_title;
    public ?string $resources_description;
    
    public ?string $faq_title;
    public ?string $faq_description;
    
    public ?string $stories_title;
    public ?string $stories_description;
    
    public ?string $tools_title;
    public ?string $tools_description;

    public static function group(): string
    {
        return 'seo';
    }
}

<?php

namespace App\Services;

use App\Settings\SeoSettings;

class MetaService
{
    protected string $title;
    protected string $description;
    protected ?string $image = null;
    protected ?string $url = null;
    protected string $type = 'website';

    public function __construct(protected SeoSettings $seoSettings)
    {
        $this->title = $seoSettings->site_name ?? config('app.name');
        $this->description = $seoSettings->site_description ?? '';
        $this->image = $seoSettings->og_image;
        $this->url = url()->current();
    }

    public function setMeta(string $title, string $description, ?string $image = null, ?string $type = 'website', ?string $url = null): self
    {
        $this->title = $title;
        $this->description = $description;
        if ($image) {
            $this->image = $image;
        }
        $this->type = $type ?? 'website';
        if ($url) {
            $this->url = $url;
        }

        return $this;
    }

    public function render(): string
    {
        $title = e($this->title);
        $description = e($this->description);
        $image = $this->image ? asset($this->image) : null;
        $url = $this->url;
        $siteName = e($this->seoSettings->site_name ?? config('app.name'));

        $html = [];
        
        // Standard Meta
        $html[] = "<title>{$title} - {$siteName}</title>";
        $html[] = "<meta name=\"description\" content=\"{$description}\">";
        $html[] = "<link rel=\"canonical\" href=\"{$url}\">";

        // OpenGraph
        $html[] = "<meta property=\"og:site_name\" content=\"{$siteName}\">";
        $html[] = "<meta property=\"og:title\" content=\"{$title}\">";
        $html[] = "<meta property=\"og:description\" content=\"{$description}\">";
        $html[] = "<meta property=\"og:type\" content=\"{$this->type}\">";
        $html[] = "<meta property=\"og:url\" content=\"{$url}\">";
        if ($image) {
            $html[] = "<meta property=\"og:image\" content=\"{$image}\">";
        }

        // Twitter Card
        $html[] = "<meta name=\"twitter:card\" content=\"summary_large_image\">";
        if ($this->seoSettings->twitter_handle) {
            $html[] = "<meta name=\"twitter:site\" content=\"{$this->seoSettings->twitter_handle}\">";
        }
        $html[] = "<meta name=\"twitter:title\" content=\"{$title}\">";
        $html[] = "<meta name=\"twitter:description\" content=\"{$description}\">";
        if ($image) {
            $html[] = "<meta name=\"twitter:image\" content=\"{$image}\">";
        }

        return implode("\n    ", $html);
    }
}

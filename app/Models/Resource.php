<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'resource_type',
        'category',
        'difficulty_level',
        'featured_image',
        'file_path',
        'external_url',
        'is_active',
        'is_featured',
        'is_published',
        'views_count',
        'downloads_count',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'category' => \App\Enums\ResourceCategory::class,
        'difficulty_level' => \App\Enums\DifficultyLevel::class,
        'resource_type' => \App\Enums\ResourceType::class,
        'published_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($resource) {
            if (empty($resource->slug) || $resource->isDirty('title')) {
                $slug = Str::slug($resource->title);
                $originalSlug = $slug;
                $count = 1;

                while (static::where('slug', $slug)->where('id', '!=', $resource->id)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $resource->slug = $slug;
            }
        });
    }

    /**
     * Get all views for this resource
     */
    public function views()
    {
        return $this->hasMany(ResourceView::class);
    }

    /**
     * Get all downloads for this resource
     */
    public function downloads()
    {
        return $this->hasMany(ResourceDownload::class);
    }

    /**
     * Scope: Active resources
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Published resources
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope: Featured resources
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: Filter by resource type
     */
    public function scopeByType($query, $type)
    {
        if ($type) {
            return $query->where('resource_type', $type);
        }
        return $query;
    }

    /**
     * Scope: Filter by category
     */
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * Scope: Filter by difficulty
     */
    public function scopeByDifficulty($query, $difficulty)
    {
        if ($difficulty) {
            return $query->where('difficulty_level', $difficulty);
        }
        return $query;
    }

    /**
     * Scope: Search
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }
        return $query;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'author_id',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
        'is_featured',
        'views_count',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function getFeaturedImageUrlAttribute(): string
    {
        if ($this->featured_image) {
            return \Illuminate\Support\Str::contains($this->featured_image, 'http')
                ? $this->featured_image
                : \Illuminate\Support\Facades\Storage::url($this->featured_image);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->title) . '&color=3b82f6&background=eff6ff';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $fillable = [
        'title',
        'image',
        'url',
        'position',
        'is_active',
        'start_date',
        'end_date',
        'clicks_count',
        'impressions_count',
    ];

    protected $casts = [
        'position' => \App\Enums\AdPosition::class,
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'clicks_count' => 'integer',
        'impressions_count' => 'integer',
    ];

    public function clicks()
    {
        return $this->hasMany(AdClick::class);
    }

    public function trackClick(?int $userId = null): void
    {
        AdClick::create([
            'ad_id' => $this->id,
            'user_id' => $userId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'referrer' => request()->header('referer'),
        ]);

        $this->increment('clicks_count', 1);
    }

    public function trackImpression(): void
    {
        $this->increment('impressions_count', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function scopePosition($query, \App\Enums\AdPosition $position)
    {
        return $query->where('position', $position);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return \Illuminate\Support\Str::contains($this->image, 'http')
                ? $this->image
                : \Illuminate\Support\Facades\Storage::disk('public')->url($this->image);
        }

        return 'https://via.placeholder.com/1920x1080?text=Scholarpeep+Ad';
    }
}

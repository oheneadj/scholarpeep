<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'tier',
        'category',
        'criteria_type',
        'criteria_value',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'criteria_value' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Users who have earned this badge
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_badges')
            ->withPivot(['progress', 'earned_at'])
            ->withTimestamps();
    }

    /**
     * Scope: Active badges only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Filter by category
     */
    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Filter by tier
     */
    public function scopeByTier($query, string $tier)
    {
        return $query->where('tier', $tier);
    }

    /**
     * Get tier color for UI
     */
    public function getTierColorAttribute(): string
    {
        return match($this->tier) {
            'bronze' => 'amber',
            'silver' => 'gray',
            'gold' => 'yellow',
            'platinum' => 'purple',
            default => 'gray',
        };
    }
}

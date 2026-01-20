<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRule extends Model
{
    protected $fillable = [
        'action_type',
        'points',
        'description',
        'is_active',
        'max_per_day',
    ];

    protected $casts = [
        'points' => 'integer',
        'is_active' => 'boolean',
        'max_per_day' => 'integer',
    ];

    /**
     * Scope: Active rules only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get rule by action type
     */
    public static function getByAction(string $actionType): ?self
    {
        return static::where('action_type', $actionType)
            ->where('is_active', true)
            ->first();
    }
}

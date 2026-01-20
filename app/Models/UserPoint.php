<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserPoint extends Model
{
    protected $fillable = [
        'user_id',
        'total_points',
        'lifetime_points',
        'current_level',
    ];

    protected $casts = [
        'total_points' => 'integer',
        'lifetime_points' => 'integer',
        'current_level' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PointTransaction::class, 'user_id', 'user_id');
    }

    /**
     * Calculate level based on total points
     */
    public function calculateLevel(): int
    {
        // Level formula: Level = floor(sqrt(total_points / 100))
        // Level 1: 0-99 points
        // Level 2: 100-399 points
        // Level 3: 400-899 points
        // Level 4: 900-1599 points
        // etc.
        return max(1, (int) floor(sqrt($this->total_points / 100)) + 1);
    }

    /**
     * Get points needed for next level
     */
    public function pointsToNextLevel(): int
    {
        $nextLevel = $this->current_level + 1;
        $pointsNeeded = pow($nextLevel - 1, 2) * 100;
        return max(0, $pointsNeeded - $this->total_points);
    }

    /**
     * Get progress percentage to next level
     */
    public function progressToNextLevel(): float
    {
        $currentLevelPoints = pow($this->current_level - 1, 2) * 100;
        $nextLevelPoints = pow($this->current_level, 2) * 100;
        $range = $nextLevelPoints - $currentLevelPoints;
        
        if ($range == 0) return 100;
        
        $progress = (($this->total_points - $currentLevelPoints) / $range) * 100;
        return min(100, max(0, $progress));
    }
}

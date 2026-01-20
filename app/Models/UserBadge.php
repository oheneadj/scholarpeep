<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBadge extends Pivot
{
    protected $table = 'user_badges';

    protected $fillable = [
        'user_id',
        'badge_id',
        'progress',
        'earned_at',
    ];

    protected $casts = [
        'progress' => 'integer',
        'earned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function badge(): BelongsTo
    {
        return $this->belongsTo(Badge::class);
    }

    /**
     * Check if badge is earned
     */
    public function isEarned(): bool
    {
        return !is_null($this->earned_at);
    }

    /**
     * Get progress percentage
     */
    public function getProgressPercentage(): float
    {
        if ($this->isEarned()) {
            return 100;
        }

        $badge = $this->badge;
        if (!$badge || $badge->criteria_value == 0) {
            return 0;
        }

        return min(100, ($this->progress / $badge->criteria_value) * 100);
    }
}

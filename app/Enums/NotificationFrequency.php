<?php

namespace App\Enums;

enum NotificationFrequency: string
{
    case INSTANT = 'instant';
    case DAILY = 'daily';
    case WEEKLY = 'weekly';

    public function label(): string
    {
        return match ($this) {
            self::INSTANT => 'Instant Notifications',
            self::DAILY => 'Daily Digest',
            self::WEEKLY => 'Weekly Digest',
        };
    }
}

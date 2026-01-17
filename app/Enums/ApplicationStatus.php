<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case SAVED = 'saved';
    case APPLIED = 'applied';
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::SAVED => 'Saved',
            self::APPLIED => 'Applied',
            self::PENDING => 'Pending',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SAVED => 'gray',
            self::APPLIED => 'blue',
            self::PENDING => 'warning',
            self::ACCEPTED => 'success',
            self::REJECTED => 'danger',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::SAVED => 'bookmark',
            self::APPLIED => 'paper-airplane',
            self::PENDING => 'clock',
            self::ACCEPTED => 'check-circle',
            self::REJECTED => 'x-circle',
        };
    }
}

<?php

namespace App\Enums;

enum ScholarshipStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ACTIVE => 'Active',
            self::EXPIRED => 'Expired',
            self::ARCHIVED => 'Archived',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'gray',
            self::ACTIVE => 'success',
            self::EXPIRED => 'warning',
            self::ARCHIVED => 'error',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::DRAFT => 'pencil',
            self::ACTIVE => 'check-circle',
            self::EXPIRED => 'clock',
            self::ARCHIVED => 'archive',
        };
    }
}

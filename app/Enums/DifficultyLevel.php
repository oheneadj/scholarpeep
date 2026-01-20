<?php

namespace App\Enums;

enum DifficultyLevel: string
{
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';

    public function label(): string
    {
        return match ($this) {
            self::BEGINNER => 'Beginner',
            self::INTERMEDIATE => 'Intermediate',
            self::ADVANCED => 'Advanced',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::BEGINNER => 'star-01',
            self::INTERMEDIATE => 'stars-02',
            self::ADVANCED => 'award-01',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BEGINNER => 'success',
            self::INTERMEDIATE => 'warning',
            self::ADVANCED => 'danger',
        };
    }
}

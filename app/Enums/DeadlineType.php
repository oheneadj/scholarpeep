<?php

namespace App\Enums;

enum DeadlineType: string
{
    case APPLICATION = 'application';
    case EARLY_DECISION = 'early_decision';
    case REGULAR = 'regular';
    case FINAL = 'final';
    case ROUND_1 = 'round_1';
    case ROUND_2 = 'round_2';
    case ROUND_3 = 'round_3';

    public function label(): string
    {
        return match ($this) {
            self::APPLICATION => 'Application Deadline',
            self::EARLY_DECISION => 'Early Decision',
            self::REGULAR => 'Regular Decision',
            self::FINAL => 'Final Deadline',
            self::ROUND_1 => 'Round 1',
            self::ROUND_2 => 'Round 2',
            self::ROUND_3 => 'Round 3',
        };
    }
}

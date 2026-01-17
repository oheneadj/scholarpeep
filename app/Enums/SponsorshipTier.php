<?php

namespace App\Enums;

enum SponsorshipTier: string
{
    case STANDARD = 'standard';
    case FEATURED = 'featured';
    case PREMIUM = 'premium';

    public function label(): string
    {
        return match ($this) {
            self::STANDARD => 'Standard',
            self::FEATURED => 'Featured',
            self::PREMIUM => 'Premium Sponsored',
        };
    }

    public function price(): float
    {
        return match ($this) {
            self::STANDARD => 0.00,
            self::FEATURED => 75.00,
            self::PREMIUM => 250.00,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::STANDARD => 'gray',
            self::FEATURED => 'gold',
            self::PREMIUM => 'purple',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::STANDARD => 'bg-gray-100 text-gray-800',
            self::FEATURED => 'bg-gradient-to-r from-gold-400 to-gold-600 text-white shadow-sm',
            self::PREMIUM => 'bg-gradient-to-r from-purple-500 to-purple-700 text-white shadow-md',
        };
    }
}

<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;

enum UserRole: string implements HasLabel, HasColor
{
    case SUPER_ADMIN = 'super_admin';
    case EDITOR = 'editor';
    case USER = 'user';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::EDITOR => 'Editor',
            self::USER => 'User',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::SUPER_ADMIN => 'danger',
            self::EDITOR => 'info',
            self::USER => 'gray',
        };
    }
}

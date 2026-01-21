<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Pages\SettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class ManageSystem extends SettingsPage
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-cog';

    protected static string $settings = GeneralSettings::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'System Settings';

    protected static ?string $navigationLabel = 'System';

    public static function canAccess(): bool
    {
        return auth()->user()->role === \App\Enums\UserRole::SUPER_ADMIN;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Cloudflare Turnstile')
                    ->description('Manage your Cloudflare Turnstile keys for captcha protection.')
                    ->schema([
                        TextInput::make('turnstile_site_key')
                            ->label('Site Key')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('turnstile_secret_key')
                            ->label('Secret Key')
                            ->password()
                            ->revealable()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}

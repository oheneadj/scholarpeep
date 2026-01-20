<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Nigeria')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        \Filament\Forms\Components\TextInput::make('code')
                            ->required()
                            ->maxLength(10)
                            ->placeholder('e.g. NG')
                            ->unique(ignoreRecord: true),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. nigeria')
                            ->unique(ignoreRecord: true),
                    ]),
            ]);
    }
}

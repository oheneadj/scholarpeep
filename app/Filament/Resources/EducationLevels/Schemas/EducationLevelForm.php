<?php

namespace App\Filament\Resources\EducationLevels\Schemas;

use Filament\Schemas\Schema;

class EducationLevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Bachelor\'s Degree')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        \Filament\Forms\Components\TextInput::make('slug')
                            ->required()
                            ->placeholder('e.g. bachelors-degree')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                  
            ]);
    }
}

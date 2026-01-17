<?php

namespace App\Filament\Resources\Faqs\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FaqForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g., How do I reset my password?')
                    ->columnSpanFull(),
                RichEditor::make('answer')
                    ->required()
                    ->placeholder('Provide a detailed answer here...')
                    ->columnSpanFull(),
                Section::make('Settings')
                    ->schema([
                        TextInput::make('category')
                            ->placeholder('e.g., General, Billing'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->placeholder('0'),
                        Toggle::make('is_published')
                            ->default(true)
                            ->inline(false),
                    ])->columns(3),
            ]);
    }
}

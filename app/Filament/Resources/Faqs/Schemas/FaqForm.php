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
                  Section::make('Settings')
                    ->schema([
                TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. How do I reset my password?')
                    ->columnSpanFull(),
                RichEditor::make('answer')
                    ->required()
                    ->placeholder('Provide a detailed answer here...')
                    ->columnSpanFull(),
                        TextInput::make('category')
                            ->label('Category')
                            ->placeholder('e.g., General, Billing'),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->label('Sort Order')
                            ->helperText('The order in which the FAQ will be displayed.')
                            ->default(0)
                            ->placeholder('0'),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true)
                            ->inline(false),
                    ])->columns(2),
            ]);
    }
}

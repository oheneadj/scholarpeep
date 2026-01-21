<?php

namespace App\Filament\Resources\SuccessStories\Schemas;

use Filament\Schemas\Schema;

class SuccessStoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make()
                    ->schema([
                        \Filament\Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->required(),
                        \Filament\Forms\Components\Select::make('scholarship_id')
                            ->relationship('scholarship', 'title')
                            ->searchable()
                            ->nullable(),
                        \Filament\Forms\Components\TextInput::make('title')
                            ->required()
                            ->placeholder('e.g. How John Secured a Full Ride')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('student_name')
                            ->required()
                            ->placeholder('e.g. John Doe')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('university')
                            ->placeholder('e.g. Harvard University')
                            ->maxLength(255),
                        \Filament\Forms\Components\TextInput::make('country')
                            ->placeholder('e.g. USA')
                            ->maxLength(255),
                        \Filament\Forms\Components\Textarea::make('story')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\FileUpload::make('student_photo')
                            ->image()
                            ->disk('public')
                            ->directory('success-stories'),
                        \Filament\Forms\Components\Toggle::make('is_approved')
                            ->label('Approved')
                            ->default(false),
                        \Filament\Forms\Components\Toggle::make('is_featured')
                            ->label('Featured on Homepage')
                            ->default(false),
                    ])->columns(2)
            ]);
    }
}

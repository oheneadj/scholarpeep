<?php

namespace App\Filament\Resources\Resources\Schemas;

use App\Enums\DifficultyLevel;
use App\Enums\ResourceCategory;
use App\Enums\ResourceType;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Resource Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. Scholarship Application Guide')
                            ->columnSpanFull(),
                            
                        Select::make('resource_type')
                            ->options(ResourceType::class)
                            ->required()
                            ->placeholder('Select type')
                            ->live(),
                            
                        Select::make('category')
                            ->options(ResourceCategory::class)
                            ->required()
                            ->placeholder('Select category'),
                            
                        Select::make('difficulty_level')
                            ->options(DifficultyLevel::class)
                            ->required()
                            ->placeholder('Select level'),
                            
                        Textarea::make('description')
                            ->required()
                            ->rows(3)
                            ->placeholder('Brief description of the resource content.')
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('content')
                            ->placeholder('Detailed content relating to the resource...')
                            ->columnSpanFull(),
                    ]),

                Section::make('Files & Links')
                    ->schema([
                        FileUpload::make('file_path')
                            ->label('Downloadable File')
                            ->directory('resources/files')
                            ->maxSize(10240)
                            ->visible(function ($get) {
                                $type = $get('resource_type');
                                
                                // Permissive check for both enum cases and strings (case-insensitive)
                                $value = $type instanceof \App\Enums\ResourceType 
                                    ? $type->value 
                                    : strtolower((string) $type);
                                
                                return in_array($value, ['guide', 'template', 'checklist']);
                            })
                            ->helperText('Supported formats: PDF, DOC, DOCX. Max size: 10MB.')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->columnSpanFull(),
                            
                        TextInput::make('external_url')
                            ->label('External Link')
                            ->url()
                            ->placeholder('https://example.com')
                            ->columnSpanFull(),
                    ]),

                Section::make('Publishing')
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                            
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                            
                        Toggle::make('is_featured')
                            ->label('Featured'),
                            
                        DateTimePicker::make('published_at')
                            ->label('Publish Date')
                            ->default(now()),
                    ])->columns(4),
            ]);
    }
}

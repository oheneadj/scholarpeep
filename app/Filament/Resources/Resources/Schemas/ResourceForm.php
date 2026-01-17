<?php

namespace App\Filament\Resources\Resources\Schemas;

use App\Enums\ResourceType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class ResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->placeholder('e.g., Scholarship Application Guide'),
                        Select::make('resource_type')
                            ->options(ResourceType::class)
                            ->required()
                            ->placeholder('Select resource type'),
                        Textarea::make('description')
                            ->required()
                            ->placeholder('Brief description of the resource...')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Content & Source')
                    ->schema([
                        FileUpload::make('file_path')
                            ->directory('resources')
                            ->visible(fn($get) => in_array($get('resource_type'), [ResourceType::GUIDE->value, ResourceType::TEMPLATE->value, ResourceType::CHECKLIST->value])),
                        TextInput::make('external_url')
                            ->url()
                            ->placeholder('https://example.com/item')
                            ->visible(fn($get) => $get('resource_type') === ResourceType::EXTERNAL_LINK->value),
                        Toggle::make('is_active')
                            ->label('Visible to Students')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }
}

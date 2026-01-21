<?php

namespace App\Filament\Resources\Ads\Schemas;

use App\Enums\AdPosition;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AdForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Ad Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->placeholder('e.g. Summer Sale Banner')
                            ->maxLength(255),

                        Select::make('position')
                            ->options(AdPosition::class)
                            ->required()
                            ->default(AdPosition::SIDEBAR)
                            ->helperText('Choose where this ad should be displayed'),
                        
                        FileUpload::make('image')
                            ->image()
                            ->disk('public')
                            ->visibility('public')
                            ->directory('ads')
                            ->required()
                            ->helperText('Supported Aspect Ratios: 16:9 (1920x1080) or 1:1 (1080x1080). WebP format is supported and recommended.')
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(2048),
                        
                        TextInput::make('url')
                            ->url()
                            ->required()
                            ->maxLength(255)
                            ->label('Target URL')
                            ->helperText('The URL users will be redirected to when they click the ad'),
                        
                      
                        
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active ads will be displayed'),
                    ])
                    ->columns(2),
                
                \Filament\Schemas\Components\Section::make('Scheduling')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->helperText('Leave empty to start immediately'),
                        
                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->helperText('Leave empty for no end date')
                            ->after('start_date'),
                    ])
                    ->columns(2),
                
                \Filament\Schemas\Components\Section::make('Statistics')
                    ->schema([
                        TextInput::make('clicks_count')
                            ->label('Total Clicks')
                            ->numeric()
                            ->disabled()
                            ->default(0),
                        
                        TextInput::make('impressions_count')
                            ->label('Total Impressions')
                            ->numeric()
                            ->disabled()
                            ->default(0),
                    ])
                    ->columns(2)
                    ->hidden(fn ($record) => $record === null),
            ]);
    }
}

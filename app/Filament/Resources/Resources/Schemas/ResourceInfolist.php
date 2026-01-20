<?php

namespace App\Filament\Resources\Resources\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ResourceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Resource Information')
                    ->schema([
                        TextEntry::make('title')
                            ->size('lg')
                            ->weight('bold'),
                            
                        TextEntry::make('description')
                            ->columnSpanFull(),
                            
                        TextEntry::make('resource_type')
                            ->label('Type')
                            ->badge(),
                            
                        TextEntry::make('category')
                            ->badge(),
                            
                        TextEntry::make('difficulty_level')
                            ->label('Difficulty')
                            ->badge(),
                    ])->columns(2),
                    
                Section::make('Content')
                    ->schema([
                        TextEntry::make('content')
                            ->html()
                            ->placeholder('No content')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(fn ($record) => empty($record->content)),
                    
                Section::make('Files & Links')
                    ->schema([
                        TextEntry::make('file_path')
                            ->label('Downloadable File')
                            ->placeholder('-')
                            ->url(fn ($record) => $record->file_path ? asset('storage/' . $record->file_path) : null)
                            ->openUrlInNewTab(),
                            
                        TextEntry::make('external_url')
                            ->label('External Link')
                            ->placeholder('-')
                            ->url(fn ($record) => $record->external_url)
                            ->openUrlInNewTab(),
                    ])->columns(2),
                    
                Section::make('Publishing & Visibility')
                    ->schema([
                        IconEntry::make('is_published')
                            ->label('Published')
                            ->boolean(),
                            
                        IconEntry::make('is_active')
                            ->label('Active')
                            ->boolean(),
                            
                        IconEntry::make('is_featured')
                            ->label('Featured')
                            ->boolean(),
                            
                        TextEntry::make('published_at')
                            ->label('Publish Date')
                            ->dateTime()
                            ->placeholder('-'),
                    ])->columns(4),
                    
                Section::make('Analytics')
                    ->schema([
                        TextEntry::make('views_count')
                            ->label('Total Views')
                            ->numeric(),
                            
                        TextEntry::make('downloads_count')
                            ->label('Total Downloads')
                            ->numeric(),
                    ])->columns(2),
                    
                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->dateTime()
                            ->placeholder('-'),
                            
                        TextEntry::make('updated_at')
                            ->dateTime()
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->collapsible()
                    ->collapsed(),
            ]);
    }
}

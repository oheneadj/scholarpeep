<?php

namespace App\Filament\Resources\Resources\Tables;

use App\Enums\DifficultyLevel;
use App\Enums\ResourceCategory;
use App\Enums\ResourceType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ResourcesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                    
                TextColumn::make('resource_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn ($state): string => match ($state instanceof ResourceType ? $state->value : strtolower($state)) {
                        'guide' => 'primary',
                        'template' => 'success',
                        'checklist' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('category')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('difficulty_level')
                    ->label('Difficulty')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn ($state): string => match ($state instanceof DifficultyLevel ? $state->value : strtolower($state)) {
                        'beginner' => 'success',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        default => 'gray',
                    })
                    ->sortable()
                    ->toggleable(),
                    
                IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                    
                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),
                    
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                    
                TextColumn::make('views_count')
                    ->label('Views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('downloads_count')
                    ->label('Downloads')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('published_at')
                    ->label('Publish Date')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('resource_type')
                    ->label('Type')
                    ->options(ResourceType::class),
                    
                SelectFilter::make('category')
                    ->options(ResourceCategory::class),
                    
                SelectFilter::make('difficulty_level')
                    ->label('Difficulty')
                    ->options(DifficultyLevel::class),
                    
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
                    
                TernaryFilter::make('is_published')
                    ->label('Published'),
                    
                TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->button()
                    ->color('gray'),
                EditAction::make()
                    ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

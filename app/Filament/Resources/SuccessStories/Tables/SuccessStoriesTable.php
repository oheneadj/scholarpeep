<?php

namespace App\Filament\Resources\SuccessStories\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class SuccessStoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('student_photo')
                    ->circular(),
                \Filament\Tables\Columns\TextColumn::make('student_name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                \Filament\Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Approved'),
                \Filament\Tables\Columns\ToggleColumn::make('is_featured')
                    ->label('Featured'),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\TernaryFilter::make('is_approved'),
                \Filament\Tables\Filters\TernaryFilter::make('is_featured'),
            ])
            ->actions([
                EditAction::make()
                    ->color('primary'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

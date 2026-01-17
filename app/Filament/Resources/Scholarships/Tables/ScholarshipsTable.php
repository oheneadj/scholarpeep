<?php

namespace App\Filament\Resources\Scholarships\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;

class ScholarshipsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                \Filament\Tables\Columns\TextColumn::make('provider_name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('award_amount')
                    ->money(fn($record) => $record->currency ?? 'USD')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('primary_deadline')
                    ->date()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('sponsorship_tier')
                    ->badge()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('views_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('applications_count')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('status')
                    ->options(\App\Enums\ScholarshipStatus::class),
                \Filament\Tables\Filters\SelectFilter::make('sponsorship_tier')
                    ->options(\App\Enums\SponsorshipTier::class),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

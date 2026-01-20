<?php

namespace App\Filament\Resources\Scholarships\Pages;

use App\Filament\Resources\Scholarships\ScholarshipResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewScholarship extends ViewRecord
{
    protected static string $resource = ScholarshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            \Filament\Actions\Action::make('preview')
                ->url(fn () => route('scholarships.show', $this->record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\IndividualScholarshipStatsWidget::class,
        ];
    }
}

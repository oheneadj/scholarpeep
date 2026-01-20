<?php

namespace App\Filament\Resources\Scholarships\Pages;

use App\Filament\Resources\Scholarships\ScholarshipResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditScholarship extends EditRecord
{
    protected static string $resource = ScholarshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            \Filament\Actions\Action::make('preview')
                ->url(fn () => route('scholarships.show', $this->record->slug))
                ->openUrlInNewTab()
                ->icon('heroicon-o-eye'),
        ];
    }
}

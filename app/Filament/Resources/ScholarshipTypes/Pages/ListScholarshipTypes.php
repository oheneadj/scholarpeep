<?php

namespace App\Filament\Resources\ScholarshipTypes\Pages;

use App\Filament\Resources\ScholarshipTypes\ScholarshipTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListScholarshipTypes extends ListRecords
{
    protected static string $resource = ScholarshipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

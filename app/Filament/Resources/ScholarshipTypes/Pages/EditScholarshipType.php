<?php

namespace App\Filament\Resources\ScholarshipTypes\Pages;

use App\Filament\Resources\ScholarshipTypes\ScholarshipTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditScholarshipType extends EditRecord
{
    protected static string $resource = ScholarshipTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

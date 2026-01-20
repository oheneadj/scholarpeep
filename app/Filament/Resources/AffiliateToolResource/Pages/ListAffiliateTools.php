<?php

namespace App\Filament\Resources\AffiliateToolResource\Pages;

use App\Filament\Resources\AffiliateToolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAffiliateTools extends ListRecords
{
    protected static string $resource = AffiliateToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

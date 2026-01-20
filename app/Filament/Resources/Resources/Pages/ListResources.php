<?php

namespace App\Filament\Resources\Resources\Pages;

use App\Filament\Resources\Resources\ResourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListResources extends ListRecords
{
    protected static string $resource = ResourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('view_public')
                ->label('View Resources')
                ->color('gray')
                ->icon('heroicon-o-eye')
                ->url(route('resources.index'))
                ->openUrlInNewTab(),
            CreateAction::make(),
        ];
    }
}

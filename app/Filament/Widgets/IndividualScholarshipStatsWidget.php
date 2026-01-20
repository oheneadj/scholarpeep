<?php

namespace App\Filament\Widgets;

use App\Models\Scholarship;
use App\Models\SavedScholarship;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class IndividualScholarshipStatsWidget extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {
        if (!$this->record) {
            return [];
        }

        $savesCount = SavedScholarship::where('scholarship_id', '=', $this->record->id)->count('*');

        return [
            Stat::make('Views', number_format($this->record->views_count))
                ->description('Total page views')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),
            Stat::make('External Clicks', number_format($this->record->clicks_count))
                ->description('Redirects to provider')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('warning'),
            Stat::make('Saves', number_format($savesCount))
                ->description('Saved by students')
                ->descriptionIcon('heroicon-m-bookmark')
                ->color('primary'),
        ];
    }
}

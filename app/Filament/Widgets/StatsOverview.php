<?php

namespace App\Filament\Widgets;

use App\Models\Scholarship;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Monthly Additions', Scholarship::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count())
                ->description('Scholarships added this month')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('warning'),
            Stat::make('Avg CTR', '4.2%')
                ->description('Application click-through rate')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->color('info'),
            Stat::make('Revenue', '$1,250')
                ->description('From sponsored listings')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}

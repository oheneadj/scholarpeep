<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\SiteTrafficChart;
use App\Filament\Widgets\ContentPerformanceChart;

class Analytics extends Page
{
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-presentation-chart-line';
    
    protected string $view = 'filament.pages.analytics';
    
    protected static \UnitEnum|string|null $navigationGroup = 'System';
    
    protected static ?int $navigationSort = 10;

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
            \App\Filament\Widgets\ScholarshipStatsWidget::class,
            SiteTrafficChart::class,
            ContentPerformanceChart::class,
        ];
    }
}

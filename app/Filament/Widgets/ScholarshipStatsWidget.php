<?php

namespace App\Filament\Widgets;

use App\Models\Scholarship;
use App\Models\ScholarshipView;
use App\Models\AffiliateClick;
use App\Models\SavedScholarship;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class ScholarshipStatsWidget extends BaseWidget
{
    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $totalViews = Scholarship::sum('views_count');
        $totalClicks = Scholarship::sum('clicks_count');
        $totalSaves = SavedScholarship::count('*');

        // Historical data for charts (last 7 days)
        $viewsData = DB::table('scholarship_views')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $clicksData = DB::table('affiliate_clicks')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('clickable_type', Scholarship::class)
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        return [
            Stat::make('Total Scholarship Views', number_format($totalViews))
                ->description('Across all active listings')
                ->descriptionIcon('heroicon-m-eye')
                ->chart($viewsData)
                ->color('success'),
            Stat::make('External Clicks', number_format($totalClicks))
                ->description('Redirects to provider sites')
                ->descriptionIcon('heroicon-m-cursor-arrow-rays')
                ->chart($clicksData)
                ->color('warning'),
            Stat::make('Saved by Students', number_format($totalSaves))
                ->description('Currently in student pipelines')
                ->descriptionIcon('heroicon-m-bookmark')
                ->color('primary'),
        ];
    }
}

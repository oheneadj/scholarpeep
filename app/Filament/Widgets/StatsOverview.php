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
        $scholarshipViews = \Illuminate\Support\Facades\DB::table('scholarship_views')->count();
        $blogViews = \Illuminate\Support\Facades\DB::table('blog_post_views')->count();
        $resourceViews = \Illuminate\Support\Facades\DB::table('resource_views')->count();
        $resourceDownloads = \Illuminate\Support\Facades\DB::table('resource_downloads')->count();
        $applications = \Illuminate\Support\Facades\DB::table('saved_scholarships')->where('status', 'applied')->count();

        // 7-day trend helper
        $getTrend = function ($table, $dateColumn = 'created_at') {
            return \Illuminate\Support\Facades\DB::table($table)
                ->select(\Illuminate\Support\Facades\DB::raw("DATE($dateColumn) as date"), \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->where($dateColumn, '>=', now()->subDays(7))
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('count')
                ->toArray();
        };

        return [
            Stat::make('Total Scholarship Views', number_format($scholarshipViews))
                ->description('All time views')
                ->descriptionIcon('heroicon-m-eye')
                ->chart($getTrend('scholarship_views'))
                ->color('success'),

            Stat::make('Total Applications', number_format($applications))
                ->description('Successful applications')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('primary'),

            Stat::make('Blog Reads', number_format($blogViews))
                ->description('Total article views')
                ->descriptionIcon('heroicon-m-book-open')
                ->chart($getTrend('blog_post_views'))
                ->color('info'),

            Stat::make('Resource Views', number_format($resourceViews))
                ->description('Total resource views')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart($getTrend('resource_views', 'viewed_at'))
                ->color('warning'),

            Stat::make('Resource Downloads', number_format($resourceDownloads))
                ->description('Files downloaded')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->chart($getTrend('resource_downloads', 'downloaded_at'))
                ->color('danger'),
        ];
    }
}

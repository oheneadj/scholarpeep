<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SiteTrafficChart extends ChartWidget
{
    protected ?string $heading = 'Traffic Overview (Last 30 Days)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(function ($daysAgo) {
            return now()->subDays($daysAgo)->format('Y-m-d');
        });

        // Helper to get daily counts
        $getDailyCounts = function ($table, $dateColumn = 'created_at') use ($days) {
            try {
                $counts = DB::table($table)
                    ->select(DB::raw("DATE($dateColumn) as date"), DB::raw('count(*) as count'))
                    ->where($dateColumn, '>=', now()->subDays(30))
                    ->groupBy('date')
                    ->pluck('count', 'date');

                return $days->map(fn ($date) => $counts->get($date, 0));
            } catch (\Exception $e) {
                return $days->map(fn () => 0);
            }
        };

        return [
            'datasets' => [
                [
                    'label' => 'Scholarship Views',
                    'data' => $getDailyCounts('scholarship_views'),
                    'borderColor' => '#3b82f6', // Primary Blue
                    'fill' => false,
                ],
                [
                    'label' => 'Blog Views',
                    'data' => $getDailyCounts('blog_post_views'),
                    'borderColor' => '#10b981', // Emerald
                    'fill' => false,
                ],
                [
                    'label' => 'Resource Views',
                    'data' => $getDailyCounts('resource_views', 'viewed_at'),
                    'borderColor' => '#f59e0b', // Amber
                    'fill' => false,
                ],
            ],
            'labels' => $days->map(fn ($date) => Carbon::parse($date)->format('M d')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

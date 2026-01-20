<?php

namespace App\Filament\Widgets;

use App\Models\AffiliateClick;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AffiliateClicksChart extends ChartWidget
{
    protected ?string $heading = 'Affiliate & Tool Clicks (Last 30 Days)';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(function ($daysAgo) {
            return now()->subDays($daysAgo)->format('Y-m-d');
        });

        // Query counts per day
        $counts = AffiliateClick::select(DB::raw("DATE(created_at) as date"), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->pluck('count', 'date');

        $data = $days->map(fn ($date) => $counts->get($date, 0));

        return [
            'datasets' => [
                [
                    'label' => 'Clicks',
                    'data' => $data,
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => $days->map(fn ($date) => Carbon::parse($date)->format('M d')),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

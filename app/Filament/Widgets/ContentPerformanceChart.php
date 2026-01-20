<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class ContentPerformanceChart extends ChartWidget
{
    protected ?string $heading = 'Top 5 Scholarships by Views';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $topScholarships = DB::table('scholarship_views')
            ->join('scholarships', 'scholarship_views.scholarship_id', '=', 'scholarships.id')
            ->select('scholarships.title', DB::raw('count(*) as views'))
            ->groupBy('scholarships.id', 'scholarships.title')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => $topScholarships->pluck('views'),
                    'backgroundColor' => [
                        '#3b82f6', 
                        '#60a5fa', 
                        '#93c5fd', 
                        '#bfdbfe', 
                        '#dbeafe'
                    ],
                ],
            ],
            'labels' => $topScholarships->pluck('title'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

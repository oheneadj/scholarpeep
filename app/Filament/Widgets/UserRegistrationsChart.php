<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserRegistrationsChart extends ChartWidget
{
    protected ?string $heading = 'User Registrations (Last 30 Days)';
    
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $days = collect(range(29, 0))->map(function ($daysAgo) {
            return now()->subDays($daysAgo)->format('Y-m-d');
        });

        $counts = User::select(DB::raw("DATE(created_at) as date"), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->pluck('count', 'date');

        $data = $days->map(fn ($date) => $counts->get($date, 0));

        return [
            'datasets' => [
                [
                    'label' => 'Registrations',
                    'data' => $data,
                    'backgroundColor' => '#8b5cf6', // Violet
                    'borderColor' => '#8b5cf6',
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

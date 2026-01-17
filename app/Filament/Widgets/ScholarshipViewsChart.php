<?php

namespace App\Filament\Widgets;

use App\Models\Scholarship;
use Filament\Widgets\ChartWidget;

class ScholarshipViewsChart extends ChartWidget
{
    protected ?string $heading = 'Daily Scholarship Views';

    protected function getData(): array
    {
        // Sample data for visualization (in a real app, we'd query a views table)
        return [
            'datasets' => [
                [
                    'label' => 'Views',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'fill' => 'start',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

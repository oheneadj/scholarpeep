<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ApplicationClicksChart extends ChartWidget
{
    protected ?string $heading = 'Application Clicks';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Clicks',
                    'data' => [5, 12, 8, 15, 25, 30, 28, 40, 35, 50, 45, 60],
                    'backgroundColor' => '#3b82f6',
                    'borderColor' => '#3b82f6',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

<?php

namespace Database\Seeders;

use App\Models\AffiliateTool;
use Illuminate\Database\Seeder;

class AffiliateToolSeeder extends Seeder
{
    public function run(): void
    {
        $tools = [
            [
                'name' => 'Heartfelt Reflections',
                'description' => "A deep dive into emotional experiences and personal growth, sharing valuable insights on life's most meaningful moments.",
                'url' => 'https://example.com/reflections',
                'icon' => 'Heroicon::OutlinedSparkles',
                'sort_order' => 1,
            ],
            [
                'name' => 'Latest Tech Gadgets',
                'description' => 'Explore the newest and most innovative technology products hitting the market, from smart devices to cutting-edge tools.',
                'url' => 'https://example.com/tech',
                'icon' => 'Heroicon::OutlinedCpuChip',
                'sort_order' => 2,
            ],
            [
                'name' => 'Trends For 2024',
                'description' => 'A look ahead at the emerging trends that will shape the world in 2024, from lifestyle shifts to groundbreaking innovations.',
                'url' => 'https://example.com/trends',
                'icon' => 'Heroicon::OutlinedChartBar',
                'sort_order' => 3,
            ],
        ];

        foreach ($tools as $tool) {
            AffiliateTool::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($tool['name'])],
                $tool
            );
        }
    }
}

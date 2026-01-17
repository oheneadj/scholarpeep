<?php

namespace Database\Seeders;

use App\Models\EducationLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EducationLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'High School', 'order' => 1],
            ['name' => 'Undergraduate', 'order' => 2],
            ['name' => 'Masters', 'order' => 3],
            ['name' => 'PhD / Doctorate', 'order' => 4],
            ['name' => 'Postdoctoral', 'order' => 5],
        ];

        foreach ($levels as $level) {
            EducationLevel::firstOrCreate(
                ['slug' => Str::slug($level['name'])],
                [
                    'name' => $level['name'],
                    'order' => $level['order'],
                ]
            );
        }
    }
}

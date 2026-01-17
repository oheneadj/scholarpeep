<?php

namespace Database\Seeders;

use App\Models\ScholarshipType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ScholarshipTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Merit-Based',
                'description' => 'Awarded based on academic, athletic, artistic, or other achievements',
            ],
            [
                'name' => 'Need-Based',
                'description' => 'Awarded based on financial need',
            ],
            [
                'name' => 'Athletic',
                'description' => 'Awarded to student athletes',
            ],
            [
                'name' => 'Minority',
                'description' => 'Awarded to students from underrepresented groups',
            ],
            [
                'name' => 'Women',
                'description' => 'Awarded specifically to female students',
            ],
            [
                'name' => 'International',
                'description' => 'Awarded to international students',
            ],
            [
                'name' => 'Research',
                'description' => 'Awarded for research projects and studies',
            ],
            [
                'name' => 'Community Service',
                'description' => 'Awarded for community involvement and service',
            ],
        ];

        foreach ($types as $type) {
            ScholarshipType::firstOrCreate(
                ['slug' => Str::slug($type['name'])],
                $type
            );
        }
    }
}

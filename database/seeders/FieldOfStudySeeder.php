<?php

namespace Database\Seeders;

use App\Models\FieldOfStudy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FieldOfStudySeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            'Computer Science',
            'Engineering',
            'Medicine',
            'Business Administration',
            'Law',
            'Education',
            'Psychology',
            'Biology',
            'Chemistry',
            'Physics',
            'Mathematics',
            'Economics',
            'Political Science',
            'Sociology',
            'History',
            'English Literature',
            'Art & Design',
            'Music',
            'Nursing',
            'Public Health',
            'Environmental Science',
            'Agriculture',
            'Architecture',
            'Journalism',
            'Communications',
        ];

        foreach ($fields as $field) {
            FieldOfStudy::firstOrCreate(
                ['slug' => Str::slug($field)],
                ['name' => $field]
            );
        }
    }
}

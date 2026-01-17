<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed reference data
        $this->call([
            CountrySeeder::class,
            EducationLevelSeeder::class,
            FieldOfStudySeeder::class,
            ScholarshipTypeSeeder::class,
        ]);

        // Seed sample scholarships
        $this->call(ScholarshipSeeder::class);
        $this->call(BlogPostSeeder::class);
    }
}

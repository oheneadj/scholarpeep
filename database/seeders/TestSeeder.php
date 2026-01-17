<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Scholarship;
use App\Models\ScholarshipDeadline;
use App\Models\ScholarshipRequirement;
use App\Models\SavedScholarship;
use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use App\Models\ScholarshipType;
use App\Enums\ApplicationStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure reference data exists
        $this->call([
            CountrySeeder::class,
            EducationLevelSeeder::class,
            FieldOfStudySeeder::class,
            ScholarshipTypeSeeder::class,
        ]);

        // 2. Create Test Users
        $student = User::updateOrCreate(
            ['email' => 'student@test.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        // 3. Create Scholarships with relationships
        $countries = Country::all();
        $levels = EducationLevel::all();
        $fields = FieldOfStudy::all();
        $types = ScholarshipType::all();

        Scholarship::factory()
            ->count(20)
            ->create()
            ->each(function ($scholarship) use ($countries, $levels, $fields, $types) {
                // Attach random relations
                $scholarship->countries()->attach($countries->random(rand(1, 3))->pluck('id'));
                $scholarship->educationLevels()->attach($levels->random(rand(1, 2))->pluck('id'));
                $scholarship->fieldsOfStudy()->attach($fields->random(rand(1, 3))->pluck('id'));
                $scholarship->scholarshipTypes()->attach($types->random(rand(1, 2))->pluck('id'));

                // Add deadlines
                ScholarshipDeadline::factory()->count(rand(1, 3))->create([
                    'scholarship_id' => $scholarship->id,
                ]);

                // Add requirements
                ScholarshipRequirement::factory()->count(rand(3, 6))->create([
                    'scholarship_id' => $scholarship->id,
                ]);
            });

        // 4. Populate Student Dashboard
        $allScholarships = Scholarship::all();

        // Save some scholarships with different statuses
        foreach (ApplicationStatus::cases() as $status) {
            $count = rand(1, 3);
            $randomScholarships = $allScholarships->random($count);

            foreach ($randomScholarships as $scholarship) {
                SavedScholarship::updateOrCreate(
                    [
                        'user_id' => $student->id,
                        'scholarship_id' => $scholarship->id,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        }
    }
}

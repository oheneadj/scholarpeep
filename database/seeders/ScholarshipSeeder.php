<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\EducationLevel;
use App\Models\FieldOfStudy;
use App\Models\Scholarship;
use App\Models\ScholarshipType;
use App\Models\ScholarshipDeadline;
use App\Models\ScholarshipRequirement;
use App\Enums\DeadlineType;
use App\Enums\RequirementType;
use Illuminate\Database\Seeder;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::all();
        $educationLevels = EducationLevel::all();
        $fieldsOfStudy = FieldOfStudy::all();
        $scholarshipTypes = ScholarshipType::all();

        Scholarship::factory()->count(50)->create()->each(function ($scholarship) use ($countries, $educationLevels, $fieldsOfStudy, $scholarshipTypes) {
            // Attach relationships
            $scholarship->countries()->attach($countries->random(rand(1, 3))->pluck('id'));
            $scholarship->educationLevels()->attach($educationLevels->random(rand(1, 2))->pluck('id'));
            $scholarship->fieldsOfStudy()->attach($fieldsOfStudy->random(rand(1, 5))->pluck('id'));
            $scholarship->scholarshipTypes()->attach($scholarshipTypes->random(rand(1, 2))->pluck('id'));

            // Add deadlines
            ScholarshipDeadline::create([
                'scholarship_id' => $scholarship->id,
                'type' => DeadlineType::APPLICATION,
                'date' => $scholarship->primary_deadline,
                'description' => 'Main application deadline',
            ]);

            if (rand(1, 10) > 7) {
                ScholarshipDeadline::create([
                    'scholarship_id' => $scholarship->id,
                    'type' => DeadlineType::EARLY_DECISION,
                    'date' => $scholarship->primary_deadline->subMonths(2),
                    'description' => 'Early decision deadline',
                ]);
            }

            // Add requirements
            $requirements = [
                ['type' => RequirementType::TRANSCRIPT, 'title' => 'Academic Transcript'],
                ['type' => RequirementType::ESSAY, 'title' => 'Personal Statement'],
                ['type' => RequirementType::RECOMMENDATION_LETTER, 'title' => '2 Letters of Recommendation'],
                ['type' => RequirementType::DOCUMENT, 'title' => 'Proof of Citizenship'],
            ];

            foreach ($requirements as $index => $req) {
                ScholarshipRequirement::create(array_merge($req, [
                    'scholarship_id' => $scholarship->id,
                    'description' => 'Required for all applicants.',
                    'is_required' => true,
                    'order' => $index,
                ]));
            }
        });
    }
}

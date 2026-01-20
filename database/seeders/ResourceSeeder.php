<?php

namespace Database\Seeders;

use App\Models\Resource;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $resources = [
            [
                'title' => 'Complete Scholarship Application Guide',
                'description' => 'A comprehensive guide covering everything from finding scholarships to submitting winning applications. Includes templates, checklists, and expert tips.',
                'resource_type' => 'guide',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/scholarship-application-guide.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Personal Statement Template',
                'description' => 'A proven template for writing compelling personal statements. Includes examples from successful scholarship recipients.',
                'resource_type' => 'template',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/personal-statement-template.docx',
                'is_active' => true,
            ],
            [
                'title' => 'CV/Resume Builder for Students',
                'description' => 'Step-by-step guide to creating a professional CV or resume tailored for scholarship applications.',
                'resource_type' => 'template',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/cv-template.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Scholarship Essay Writing Masterclass',
                'description' => 'Video course on writing essays that stand out. Learn from scholarship committee members what they look for.',
                'resource_type' => 'video',
                'file_path' => null,
                'external_url' => 'https://www.youtube.com/watch?v=example',
                'is_active' => true,
            ],
            [
                'title' => 'Financial Aid Comparison Tool',
                'description' => 'Interactive tool to compare different types of financial aid including scholarships, grants, and loans.',
                'resource_type' => 'tool',
                'file_path' => null,
                'external_url' => 'https://example.com/tools/financial-aid-calculator',
                'is_active' => true,
            ],
            [
                'title' => 'Interview Preparation Checklist',
                'description' => 'Comprehensive checklist for preparing for scholarship interviews, including common questions and best practices.',
                'resource_type' => 'checklist',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/interview-checklist.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Recommendation Letter Request Template',
                'description' => 'Professional email template for requesting recommendation letters from professors and mentors.',
                'resource_type' => 'template',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/recommendation-request-template.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Study Abroad Scholarship Guide',
                'description' => 'Specialized guide for students seeking scholarships to study abroad, including country-specific tips.',
                'resource_type' => 'guide',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/study-abroad-guide.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'STEM Scholarship Opportunities Webinar',
                'description' => 'Recorded webinar featuring STEM scholarship opportunities and application strategies.',
                'resource_type' => 'video',
                'file_path' => null,
                'external_url' => 'https://www.youtube.com/watch?v=example2',
                'is_active' => true,
            ],
            [
                'title' => 'Scholarship Application Timeline Planner',
                'description' => 'Month-by-month planner to help you stay organized throughout the scholarship application process.',
                'resource_type' => 'checklist',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/timeline-planner.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Need-Based vs Merit-Based Scholarships Explained',
                'description' => 'Comprehensive article explaining the differences between need-based and merit-based scholarships.',
                'resource_type' => 'article',
                'file_path' => null,
                'external_url' => 'https://example.com/blog/need-vs-merit-scholarships',
                'is_active' => true,
            ],
            [
                'title' => 'GPA Calculator for Scholarship Eligibility',
                'description' => 'Calculate your GPA to determine eligibility for GPA-based scholarships.',
                'resource_type' => 'tool',
                'file_path' => null,
                'external_url' => 'https://example.com/tools/gpa-calculator',
                'is_active' => true,
            ],
            [
                'title' => 'Undergraduate Scholarship Application Checklist',
                'description' => 'Complete checklist for undergraduate students applying for scholarships.',
                'resource_type' => 'checklist',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/undergrad-checklist.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Graduate School Funding Guide',
                'description' => 'Comprehensive guide to funding options for graduate students including scholarships, fellowships, and assistantships.',
                'resource_type' => 'guide',
                'file_path' => null,
                'external_url' => 'https://example.com/resources/grad-funding-guide.pdf',
                'is_active' => true,
            ],
            [
                'title' => 'Common Scholarship Application Mistakes to Avoid',
                'description' => 'Learn from others\' mistakes! This article covers the most common errors in scholarship applications.',
                'resource_type' => 'article',
                'file_path' => null,
                'external_url' => 'https://example.com/blog/common-mistakes',
                'is_active' => true,
            ],
        ];

        foreach ($resources as $resource) {
            Resource::create($resource);
        }
    }
}

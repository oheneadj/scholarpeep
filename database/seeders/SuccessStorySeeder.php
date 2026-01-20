<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuccessStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stories = [
            [
                'student_name' => 'Sarah Jenkins',
                'title' => 'Secured $25k for Data Science Masters',
                'university' => 'Oxford University',
                'story' => 'Scholarpeep completely changed my scholarship search. The filters are so precise that I only see things I\'m actually eligible for. Secured $25k for my Masters!',
                'student_photo' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&q=80&w=200',
                'country' => 'United Kingdom',
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'student_name' => 'David Chen',
                'title' => 'Found Perfect PhD Funding',
                'university' => 'MIT',
                'story' => 'I was overwhelmed by dead links on other sites. Scholarpeep\'s verified listings saved me hours every week. The save feature let me organize my applications perfectly.',
                'student_photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&q=80&w=200',
                'country' => 'United States',
                'is_featured' => true,
                'is_approved' => true,
            ],
            [
                'student_name' => 'Amara Okeke',
                'title' => 'Full Tuition Coverage for Undergrad',
                'university' => 'University of Toronto',
                'story' => 'As an international student, finding funding seemed impossible. The \'International Students\' filter here is a lifesaver. Found full tuition coverage!',
                'student_photo' => 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&q=80&w=200',
                'country' => 'Canada',
                'is_featured' => true,
                'is_approved' => true,
            ],
        ];

        $user = \App\Models\User::first() ?? \App\Models\User::factory()->create();

        foreach ($stories as $story) {
            \App\Models\SuccessStory::create(array_merge($story, [
                'user_id' => $user->id,
            ]));
        }

        \App\Models\SuccessStory::factory()->count(10)->create();
    }
}

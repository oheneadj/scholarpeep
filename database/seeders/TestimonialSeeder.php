<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Sarah Jenkins',
                'role' => 'Masters in Data Science, Oxford',
                'quote' => 'Scholarpeep completely changed my scholarship search. The filters are so precise that I only see things I\'m actually eligible for. Secured $25k for my Masters!',
                'image_url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'David Chen',
                'role' => 'PhD in Bioengineering, MIT',
                'quote' => 'I was overwhelmed by dead links on other sites. Scholarpeep\'s verified listings saved me hours every week. The save feature let me organize my applications perfectly.',
                'image_url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name' => 'Amara Okeke',
                'role' => 'Undergraduate, University of Toronto',
                'quote' => 'As an international student, finding funding seemed impossible. The \'International Students\' filter here is a lifesaver. Found full tuition coverage!',
                'image_url' => 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                'is_active' => true,
                'is_featured' => true,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}

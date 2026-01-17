<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $posts = [
            [
                'title' => 'Top 10 Fully Funded Scholarships for 2026',
                'excerpt' => 'Discover the most prestigious fully funded scholarships available for international students this year.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'How to Write a Winning Statement of Purpose',
                'excerpt' => 'Master the art of writing a compelling SOP that stands out to admissions committees.',
                'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Studying in the UK: A Complete Guide',
                'excerpt' => 'Everything you need to know about student visas, university applications, and life in the UK.',
                'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'The Hidden Costs of Studying Abroad',
                'excerpt' => 'Budgeting for your education abroad? Don\'t forget these often-overlooked expenses.',
                'image' => 'https://images.unsplash.com/photo-1554224155-984bb0137d6d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Ace Your Scholarship Interview',
                'excerpt' => 'Common scholarship interview questions and expert tips on how to answer them confidently.',
                'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Best Universities for STEM Degrees',
                'excerpt' => 'A ranking of the top global universities for Science, Technology, Engineering, and Math programs.',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Scholarships for Women in Tech',
                'excerpt' => 'Empowering the next generation of female tech leaders with these exclusive funding opportunities.',
                'image' => 'https://images.unsplash.com/photo-1573164713988-8665fc963095?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Work-Study Opportunities for International Students',
                'excerpt' => 'Learn how to balance work and studies while abiding by visa regulations in major study destinations.',
                'image' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Comparing IELTS vs. TOEFL',
                'excerpt' => 'Which English proficiency test should you take? We break down the differences to help you decide.',
                'image' => 'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
            [
                'title' => 'Finding Accommodation as a Student Abroad',
                'excerpt' => 'Tips and tricks for securing safe, affordable, and convenient housing in a new country.',
                'image' => 'https://images.unsplash.com/photo-1555854877-bab0e564b8d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            ],
        ];

        foreach ($posts as $post) {
            BlogPost::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => '<p>' . $post['excerpt'] . '</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>',
                'excerpt' => $post['excerpt'],
                'featured_image' => $post['image'],
                'author_id' => $user->id,
                'is_published' => true,
                'published_at' => now(),
                'meta_title' => $post['title'],
                'meta_description' => $post['excerpt'],
                'views_count' => rand(100, 5000),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure there's at least one admin/editor user to assign distinct authorship if desired
        // For now, factory creates users, which is fine.

        BlogPost::factory(20)->create();
    }
}

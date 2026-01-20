<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_rules', function (Blueprint $table) {
            $table->id();
            $table->string('action_type')->unique();
            $table->integer('points');
            $table->string('description');
            $table->boolean('is_active')->default(true);
            $table->integer('max_per_day')->nullable();
            $table->timestamps();

            $table->index('is_active');
        });

        // Seed default point rules
        DB::table('point_rules')->insert([
            ['action_type' => 'profile_completed', 'points' => 50, 'description' => 'Complete your profile', 'max_per_day' => 1],
            ['action_type' => 'first_scholarship_saved', 'points' => 20, 'description' => 'Save your first scholarship', 'max_per_day' => 1],
            ['action_type' => 'scholarship_saved', 'points' => 5, 'description' => 'Save a scholarship', 'max_per_day' => 10],
            ['action_type' => 'application_submitted', 'points' => 100, 'description' => 'Submit an application', 'max_per_day' => null],
            ['action_type' => 'resource_downloaded', 'points' => 10, 'description' => 'Download a resource', 'max_per_day' => 20],
            ['action_type' => 'blog_post_read', 'points' => 5, 'description' => 'Read a blog post', 'max_per_day' => 10],
            ['action_type' => 'daily_login', 'points' => 5, 'description' => 'Daily login bonus', 'max_per_day' => 1],
            ['action_type' => 'referral_signup', 'points' => 200, 'description' => 'Refer a friend who signs up', 'max_per_day' => null],
            ['action_type' => 'success_story_submitted', 'points' => 150, 'description' => 'Share your success story', 'max_per_day' => null],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('point_rules');
    }
};

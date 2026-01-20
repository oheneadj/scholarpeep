<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('tier'); // bronze, silver, gold, platinum
            $table->string('category'); // scholarship_hunter, application_master, etc.
            $table->string('criteria_type'); // count, streak, points
            $table->integer('criteria_value');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category', 'tier']);
            $table->index('is_active');
        });

        // Seed default badges
        $badges = [
            // Scholarship Hunter
            ['name' => 'Scholarship Explorer', 'slug' => 'scholarship-explorer', 'description' => 'Saved 5 scholarships', 'tier' => 'bronze', 'category' => 'scholarship_hunter', 'criteria_type' => 'saved_scholarships_count', 'criteria_value' => 5, 'icon' => '🔍'],
            ['name' => 'Scholarship Collector', 'slug' => 'scholarship-collector', 'description' => 'Saved 25 scholarships', 'tier' => 'silver', 'category' => 'scholarship_hunter', 'criteria_type' => 'saved_scholarships_count', 'criteria_value' => 25, 'icon' => '📚'],
            ['name' => 'Scholarship Master', 'slug' => 'scholarship-master', 'description' => 'Saved 100 scholarships', 'tier' => 'gold', 'category' => 'scholarship_hunter', 'criteria_type' => 'saved_scholarships_count', 'criteria_value' => 100, 'icon' => '🏆'],
            ['name' => 'Scholarship Legend', 'slug' => 'scholarship-legend', 'description' => 'Saved 500 scholarships', 'tier' => 'platinum', 'category' => 'scholarship_hunter', 'criteria_type' => 'saved_scholarships_count', 'criteria_value' => 500, 'icon' => '👑'],

            // Application Master
            ['name' => 'First Step', 'slug' => 'first-step', 'description' => 'Submitted 1 application', 'tier' => 'bronze', 'category' => 'application_master', 'criteria_type' => 'applications_count', 'criteria_value' => 1, 'icon' => '📝'],
            ['name' => 'Application Pro', 'slug' => 'application-pro', 'description' => 'Submitted 5 applications', 'tier' => 'silver', 'category' => 'application_master', 'criteria_type' => 'applications_count', 'criteria_value' => 5, 'icon' => '✍️'],
            ['name' => 'Application Expert', 'slug' => 'application-expert', 'description' => 'Submitted 20 applications', 'tier' => 'gold', 'category' => 'application_master', 'criteria_type' => 'applications_count', 'criteria_value' => 20, 'icon' => '🎯'],
            ['name' => 'Application Champion', 'slug' => 'application-champion', 'description' => 'Submitted 50 applications', 'tier' => 'platinum', 'category' => 'application_master', 'criteria_type' => 'applications_count', 'criteria_value' => 50, 'icon' => '🏅'],

            // Knowledge Seeker
            ['name' => 'Resource Beginner', 'slug' => 'resource-beginner', 'description' => 'Downloaded 10 resources', 'tier' => 'bronze', 'category' => 'knowledge_seeker', 'criteria_type' => 'resources_downloaded_count', 'criteria_value' => 10, 'icon' => '📖'],
            ['name' => 'Resource Enthusiast', 'slug' => 'resource-enthusiast', 'description' => 'Downloaded 50 resources', 'tier' => 'silver', 'category' => 'knowledge_seeker', 'criteria_type' => 'resources_downloaded_count', 'criteria_value' => 50, 'icon' => '📚'],
            ['name' => 'Knowledge Hunter', 'slug' => 'knowledge-hunter', 'description' => 'Downloaded 200 resources', 'tier' => 'gold', 'category' => 'knowledge_seeker', 'criteria_type' => 'resources_downloaded_count', 'criteria_value' => 200, 'icon' => '🎓'],
            ['name' => 'Knowledge Master', 'slug' => 'knowledge-master', 'description' => 'Downloaded 1000 resources', 'tier' => 'platinum', 'category' => 'knowledge_seeker', 'criteria_type' => 'resources_downloaded_count', 'criteria_value' => 1000, 'icon' => '🧠'],

            // Consistent User
            ['name' => 'Week Warrior', 'slug' => 'week-warrior', 'description' => '7-day login streak', 'tier' => 'bronze', 'category' => 'consistent_user', 'criteria_type' => 'login_streak', 'criteria_value' => 7, 'icon' => '🔥'],
            ['name' => 'Month Master', 'slug' => 'month-master', 'description' => '30-day login streak', 'tier' => 'silver', 'category' => 'consistent_user', 'criteria_type' => 'login_streak', 'criteria_value' => 30, 'icon' => '⚡'],
            ['name' => 'Quarter Champion', 'slug' => 'quarter-champion', 'description' => '90-day login streak', 'tier' => 'gold', 'category' => 'consistent_user', 'criteria_type' => 'login_streak', 'criteria_value' => 90, 'icon' => '💪'],
            ['name' => 'Year Legend', 'slug' => 'year-legend', 'description' => '365-day login streak', 'tier' => 'platinum', 'category' => 'consistent_user', 'criteria_type' => 'login_streak', 'criteria_value' => 365, 'icon' => '🌟'],

            // Points Achiever
            ['name' => 'Point Starter', 'slug' => 'point-starter', 'description' => 'Earned 500 total points', 'tier' => 'bronze', 'category' => 'points_achiever', 'criteria_type' => 'total_points', 'criteria_value' => 500, 'icon' => '⭐'],
            ['name' => 'Point Collector', 'slug' => 'point-collector', 'description' => 'Earned 2500 total points', 'tier' => 'silver', 'category' => 'points_achiever', 'criteria_type' => 'total_points', 'criteria_value' => 2500, 'icon' => '✨'],
            ['name' => 'Point Master', 'slug' => 'point-master', 'description' => 'Earned 10000 total points', 'tier' => 'gold', 'category' => 'points_achiever', 'criteria_type' => 'total_points', 'criteria_value' => 10000, 'icon' => '💫'],
            ['name' => 'Point Legend', 'slug' => 'point-legend', 'description' => 'Earned 50000 total points', 'tier' => 'platinum', 'category' => 'points_achiever', 'criteria_type' => 'total_points', 'criteria_value' => 50000, 'icon' => '🌠'],
        ];

        foreach ($badges as $badge) {
            DB::table('badges')->insert($badge + ['created_at' => now(), 'updated_at' => now()]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};

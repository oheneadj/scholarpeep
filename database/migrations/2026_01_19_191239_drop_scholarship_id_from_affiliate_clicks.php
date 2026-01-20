<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create new table structure
        Schema::create('affiliate_clicks_temp', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('clickable');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referrer')->nullable();
            $table->timestamps();
        });

        // 2. Copy data
        // We use raw SQL to ensure we capture everything correctly.
        // Note: The previous migration should have populated clickable_id/type.
        // We handle the case where created_at exists but updated_at might not.
        DB::statement('
            INSERT INTO affiliate_clicks_temp (id, clickable_id, clickable_type, user_id, ip_address, user_agent, referrer, created_at, updated_at)
            SELECT id, clickable_id, clickable_type, user_id, ip_address, user_agent, referrer, created_at, created_at
            FROM affiliate_clicks
        ');

        // 3. Drop old table
        Schema::drop('affiliate_clicks');

        // 4. Rename new table
        Schema::rename('affiliate_clicks_temp', 'affiliate_clicks');
    }

    public function down(): void
    {
        // Re-adding scholarship_id is complex because we lost the data mapping if we didn't back it up.
        // For this fix, we simply make it nullable if we were to reverse, or just add the column back.
        Schema::table('affiliate_clicks', function (Blueprint $table) {
            $table->unsignedBigInteger('scholarship_id')->nullable();
        });
    }
};

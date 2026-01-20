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
        Schema::table('scholarship_views', function (Blueprint $table) {
            // For collaborative filtering: filtering by scholarship, then getting users
            $table->index(['scholarship_id', 'user_id']);
        });

        Schema::table('affiliate_clicks', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('scholarship_views', function (Blueprint $table) {
            $table->dropIndex(['scholarship_id', 'user_id']);
        });

        Schema::table('affiliate_clicks', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['user_id']);
        });
    }
};

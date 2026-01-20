<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('affiliate_clicks', 'clickable_id')) {
            Schema::table('affiliate_clicks', function (Blueprint $table) {
                // Add polymorphic columns
                $table->nullableMorphs('clickable');
                $table->string('user_agent')->nullable();
                $table->string('referrer')->nullable();
            });
        }

        // Migrate existing scholarship_id data to polymorphic
        // Using string value for clickable_type directly to avoid escape issues in some contexts
        DB::table('affiliate_clicks')
            ->whereNotNull('scholarship_id')
            ->whereNull('clickable_id')
            ->update([
                'clickable_id' => DB::raw('scholarship_id'),
                'clickable_type' => 'App\Models\Scholarship',
            ]);
        
        // SQLite doesn't handle dropColumn well in all situations, 
        // especially when mixed with other operations.
        // We will skip dropping it for now or do it in a separate migration if critical.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('affiliate_clicks', function (Blueprint $table) {
            $table->unsignedBigInteger('scholarship_id')->nullable();
            
            DB::statement('UPDATE affiliate_clicks SET scholarship_id = clickable_id WHERE clickable_type = "App\\\Models\\\Scholarship"');
            
            $table->dropMorphs('clickable');
            $table->dropColumn(['user_agent', 'referrer']);
        });
    }
};

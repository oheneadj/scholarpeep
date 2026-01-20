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
        Schema::table('resources', function (Blueprint $table) {
            // Add slug for SEO-friendly URLs (nullable initially)
            $table->string('slug')->nullable()->after('title');
            
            // Add content
            $table->longText('content')->nullable()->after('description');
            
            // Add categorization
            $table->string('category')
                ->default('scholarship')
                ->after('resource_type');
            $table->string('difficulty_level')
                ->default('beginner')
                ->after('category');
            
            // Add media
            $table->string('featured_image')->nullable()->after('difficulty_level');
            
            // Add status and metrics
            $table->boolean('is_featured')->default(false)->after('is_active');
            $table->boolean('is_published')->default(true)->after('is_featured');
            $table->unsignedBigInteger('views_count')->default(0)->after('is_published');
            $table->unsignedBigInteger('downloads_count')->default(0)->after('views_count');
            
            // Add SEO fields
            $table->string('meta_title')->nullable()->after('downloads_count');
            $table->text('meta_description')->nullable()->after('meta_title');
            
            // Add publication timestamp
            $table->timestamp('published_at')->nullable()->after('meta_description');
        });

        // Generate unique slugs for existing resources
        $resources = DB::table('resources')->whereNull('slug')->get();
        foreach ($resources as $resource) {
            $slug = \Illuminate\Support\Str::slug($resource->title);
            $originalSlug = $slug;
            $counter = 1;
            
            // Ensure uniqueness
            while (DB::table('resources')->where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            DB::table('resources')->where('id', $resource->id)->update(['slug' => $slug]);
        }
        
        // Make slug unique after populating
        Schema::table('resources', function (Blueprint $table) {
            $table->unique('slug');
            
            // Add indexes for commonly queried fields
            $table->index('category');
            $table->index('difficulty_level');
            $table->index('is_featured');
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resources', function (Blueprint $table) {
            $table->dropIndex(['category']);
            $table->dropIndex(['difficulty_level']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['is_published']);
            $table->dropUnique(['slug']);
            
            $table->dropColumn([
                'slug',
                'content',
                'category',
                'difficulty_level',
                'featured_image',
                'is_featured',
                'is_published',
                'views_count',
                'downloads_count',
                'meta_title',
                'meta_description',
                'published_at',
            ]);
        });
    }
};

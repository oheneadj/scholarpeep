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
        if (!Schema::hasTable('resources')) {
            Schema::create('resources', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->longText('content')->nullable();
                
                // Resource classification
                $table->enum('resource_type', ['guide', 'template', 'tool', 'video', 'article'])->default('article');
                $table->enum('category', ['scholarship', 'essay', 'financial-aid', 'study-abroad', 'career'])->default('scholarship');
                $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
                
                // Media and files
                $table->string('featured_image')->nullable();
                $table->string('file_url')->nullable();
                $table->string('external_url')->nullable();
                
                // Status and metrics
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_published')->default(true);
                $table->unsignedBigInteger('views_count')->default(0);
                $table->unsignedBigInteger('downloads_count')->default(0);
                
                // SEO
                $table->string('meta_title')->nullable();
                $table->text('meta_description')->nullable();
                
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                
                // Indexes
                $table->index('resource_type');
                $table->index('category');
                $table->index('difficulty_level');
                $table->index('is_published');
                $table->index('is_featured');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};

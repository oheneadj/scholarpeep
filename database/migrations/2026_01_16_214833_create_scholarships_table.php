<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('eligibility_criteria')->nullable();
            $table->string('provider_name');
            $table->string('provider_logo')->nullable();
            $table->decimal('award_amount', 12, 2)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('application_url');
            $table->date('primary_deadline')->nullable();
            $table->boolean('is_rolling')->default(false);
            $table->string('sponsorship_tier')->default('standard');
            $table->date('sponsorship_start_date')->nullable();
            $table->date('sponsorship_end_date')->nullable();
            $table->text('sponsorship_notes')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('clicks_count')->default(0);
            $table->unsignedBigInteger('applications_count')->default(0);
            $table->timestamps();

            // Indexes
            $table->index('is_active');
            $table->index('primary_deadline');
            $table->index('sponsorship_tier');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};

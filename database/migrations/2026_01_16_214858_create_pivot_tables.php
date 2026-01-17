<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Scholarship - Country pivot
        Schema::create('country_scholarship', function (Blueprint $table) {
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->constrained()->onDelete('cascade');
            $table->primary(['scholarship_id', 'country_id']);
        });

        // Scholarship - Education Level pivot
        Schema::create('education_level_scholarship', function (Blueprint $table) {
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->foreignId('education_level_id')->constrained()->onDelete('cascade');
            $table->primary(['scholarship_id', 'education_level_id'], 'edu_level_scholarship_primary');
        });

        // Scholarship - Field of Study pivot
        Schema::create('field_of_study_scholarship', function (Blueprint $table) {
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->foreignId('field_of_study_id')->constrained()->onDelete('cascade');
            $table->primary(['scholarship_id', 'field_of_study_id'], 'field_scholarship_primary');
        });

        // Scholarship - Scholarship Type pivot
        Schema::create('scholarship_scholarship_type', function (Blueprint $table) {
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->foreignId('scholarship_type_id')->constrained()->onDelete('cascade');
            $table->primary(['scholarship_id', 'scholarship_type_id'], 'scholarship_type_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_scholarship_type');
        Schema::dropIfExists('field_of_study_scholarship');
        Schema::dropIfExists('education_level_scholarship');
        Schema::dropIfExists('country_scholarship');
    }
};

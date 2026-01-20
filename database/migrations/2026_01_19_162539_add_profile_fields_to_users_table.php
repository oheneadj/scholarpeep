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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('education_level_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('field_of_study_id')->nullable()->constrained('field_of_studies')->nullOnDelete();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('gpa', 3, 2)->nullable()->comment('GPA on 4.0 scale');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['education_level_id']);
            $table->dropForeign(['field_of_study_id']);
            $table->dropForeign(['country_id']);
            $table->dropColumn(['education_level_id', 'field_of_study_id', 'country_id', 'gpa']);
        });
    }
};

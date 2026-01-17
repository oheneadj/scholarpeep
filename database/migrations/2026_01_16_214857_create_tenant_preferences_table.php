<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenant_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->json('preferred_countries')->nullable();
            $table->json('preferred_education_levels')->nullable();
            $table->json('preferred_fields_of_study')->nullable();
            $table->json('preferred_scholarship_types')->nullable();
            $table->string('notification_frequency')->default('daily');
            $table->boolean('notify_new_matches')->default(true);
            $table->boolean('notify_deadlines')->default(true);
            $table->integer('deadline_reminder_days')->default(7);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_preferences');
    }
};

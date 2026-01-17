<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saved_scholarship_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('saved_scholarship_id')->constrained()->onDelete('cascade');
            $table->foreignId('scholarship_requirement_id')->constrained()->onDelete('cascade');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['saved_scholarship_id', 'scholarship_requirement_id'], 'saved_req_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_scholarship_requirements');
    }
};

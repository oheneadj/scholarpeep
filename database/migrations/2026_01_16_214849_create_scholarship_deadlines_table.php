<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('scholarship_deadlines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scholarship_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['scholarship_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_deadlines');
    }
};

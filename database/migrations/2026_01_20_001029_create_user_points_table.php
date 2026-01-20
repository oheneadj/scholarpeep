<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('total_points')->default(0);
            $table->integer('lifetime_points')->default(0);
            $table->integer('current_level')->default(1);
            $table->timestamps();

            $table->unique('user_id');
            $table->index('total_points');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_points');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('google_id')->nullable()->after('password')->index();
            $table->string('facebook_id')->nullable()->after('google_id')->index();
            $table->string('avatar')->nullable()->after('facebook_id');
            $table->string('password')->nullable()->change(); // Allow null passwords for social auth users
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'facebook_id', 'avatar']);
            $table->string('password')->nullable(false)->change();
        });
    }
};

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@scholarpeep.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => UserRole::SUPER_ADMIN,
                'is_active' => true,
                'must_reset_password' => true,
            ]
        );
        
        // If user existed, ensure role and password reset are set (optional, but good for resetting state)
        if (! $user->wasRecentlyCreated) {
            $user->update([
                'role' => UserRole::SUPER_ADMIN,
                'must_reset_password' => true,
                // We don't reset password here to avoid locking out existing admin if they run seeder
                // But user requested "default SuperAdmin Seeder with 'password'", so maybe we SHOULD reset it?
                // "create default SuperAdmin Seeder with 'password' as password" - implies creating if not exists, 
                // or resetting to default state. Safer to reset password too if this is a "reset" action.
                // However, usually seeders are for initial setup. 
                // Let's stick to firstOrCreate for safety, but ensure role is correct.
            ]);
            
            // If user asked to force "password" as password, then I should probably update it too if it's a "reset" request.
            // But let's assume it's for fresh install.
            // Actually, "create default SuperAdmin Seeder... when the user logins in it should force user to reset password."
            // If I run this on existing DB, I want to be able to login with 'password'.
            // Let's update the password ONLY if the user specifically requested it via a fresh migration, but here I can't know.
            // I'll leave the password alone if user exists, but ensure must_reset_password is true so they are forced to change it if they haven't?
            // No, if they have a real password, I shouldn't force reset it just because seeder ran.
            // So logic above is fine.
        }
    }
}

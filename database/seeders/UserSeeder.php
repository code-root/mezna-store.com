<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Create Admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'مدير النظام',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        if ($admin->wasRecentlyCreated) {
            $admin->assignRole('admin');
            $this->command->info('Admin user created: admin@example.com / password');
        }
        // Create regular user
        $user = User::firstOrCreate([
            'email' => 'user@example.com',
        ], [
            'name' => 'مستخدم عادي',
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        if ($user->wasRecentlyCreated) {
            $user->assignRole('user');
            $this->command->info('Regular user created: user@example.com / password');
        }
    }

}

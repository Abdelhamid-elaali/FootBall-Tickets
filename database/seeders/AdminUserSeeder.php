<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create admin user if it doesn't exist
        if (!User::where('email', 'admin@football-tickets.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@football-tickets.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }
    }
}

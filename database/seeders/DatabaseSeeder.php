<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user first
        $this->call([
            AdminUserSeeder::class,
        ]);

        // Create test users before booking seeder
        $testUsers = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'user'
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'password' => bcrypt('password'),
                'role' => 'user'
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'password' => bcrypt('password'),
                'role' => 'user'
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'password' => bcrypt('password'),
                'role' => 'user'
            ],
            [
                'name' => 'Emma Wilson',
                'email' => 'emma.wilson@example.com',
                'password' => bcrypt('password'),
                'role' => 'user'
            ],
        ];

        foreach ($testUsers as $user) {
            // Only create if user doesn't exist
            if (!User::where('email', $user['email'])->exists()) {
                User::factory()->create($user);
            }
        }

        // Now call remaining seeders that depend on users
        $this->call([
            MatchSeeder::class,
            BookingSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if admin user already exists to avoid duplicates
        if (!User::where('email', 'admin@gawhar.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gawhar.com',
                'password' => bcrypt('Admin@123'),
            ]);
            
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // لومړی ټول کارنونه ړنګ کړئ (پاکول)
        DB::table('users')->truncate();

        // یوازې یو اډمین کارن جوړ کړئ
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gawhar.com',
            'phone' => '0777777777',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
            'permission' => null,
            'is_active' => true,
        ]);

        $this->command->info('✅ All users deleted and new admin user created successfully!');
    }
}
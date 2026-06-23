<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@gawhar.com';
        $newPassword = 'Admin@123';

        $user = User::where('email', $email)->first();

        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->is_admin = true; // Admin رول ورکول
            $user->save();
            $this->command->info('✅ Admin password reset and role assigned!');
        } else {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($newPassword),
                'is_admin' => true,
            ]);
            $this->command->info('✅ Admin user created with admin role!');
        }
    }
}
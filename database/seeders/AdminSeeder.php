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

        // ګورئ چې آیا کارن شتون لري
        $user = User::where('email', $email)->first();

        if ($user) {
            // که کارن شتون ولري، پاسورډ یې تازه کړئ
            $user->password = Hash::make($newPassword);
            $user->save();
            $this->command->info('✅ Admin password reset successfully!');
        } else {
            // که کارن شتون ونلري، نوی کارن جوړ کړئ
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'password' => Hash::make($newPassword),
            ]);
            $this->command->info('✅ Admin user created successfully!');
        }
    }
}
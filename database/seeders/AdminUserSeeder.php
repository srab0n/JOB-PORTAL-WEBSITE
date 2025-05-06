<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user if it doesn't exist
        if (!User::where('email', 'rafi.almahmud.007@gmail.com')->exists()) {
            User::create([
                'name' => 'Rafi',
                'email' => 'rafi.almahmud.007@gmail.com',
                'password' => Hash::make('Rafi0008'),
                'user_type' => 'admin'
            ]);
        } else {
            // Update existing user to admin if not already
            $user = User::where('email', 'rafi.almahmud.007@gmail.com')->first();
            if ($user->user_type !== 'admin') {
                $user->update(['user_type' => 'admin']);
            }
        }
    }
}

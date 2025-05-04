<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Step 1: Insert into users table
        $userId = DB::table('users')->insertGetId([
            'name' => 'Rafi',
            'email' => 'rafi12@gmail.com',
            'user_type' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('Rafi0008'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Step 2: Insert into admins table
        DB::table('admins')->insert([
            'user_id' => $userId,
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
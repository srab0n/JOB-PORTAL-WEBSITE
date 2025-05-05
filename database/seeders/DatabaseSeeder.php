<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.s
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        \App\Models\Category::factory(5)->create();
        \App\Models\JobType::factory(5)->create();

    
    }
    
}
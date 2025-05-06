<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\JobType;

class CategoryAndJobTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            'Information Technology',
            'Healthcare',
            'Finance',
            'Education',
            'Marketing',
            'Engineering',
            'Sales',
            'Customer Service',
            'Design',
            'Human Resources',
            'Legal',
            'Manufacturing',
            'Retail',
            'Transportation',
            'Construction'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'status' => 1
            ]);
        }

        // Create job types
        $jobTypes = [
            'Full Time',
            'Part Time',
            'Contract',
            'Freelance',
            'Internship',
            'Temporary',
            'Remote',
            'Work From Home'
        ];

        foreach ($jobTypes as $jobType) {
            JobType::create([
                'name' => $jobType,
                'status' => 1
            ]);
        }
    }
} 
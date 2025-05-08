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

        // Add categories only if they don't exist
        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['status' => 1]
            );
        }

        // Delete any categories not in our list
        Category::whereNotIn('name', $categories)->delete();

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

        // Add job types only if they don't exist
        foreach ($jobTypes as $jobType) {
            JobType::firstOrCreate(
                ['name' => $jobType],
                ['status' => 1]
            );
        }

        // Delete any job types not in our list
        JobType::whereNotIn('name', $jobTypes)->delete();
    }
} 
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobType>
 */
class JobTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        return [
            'name' => $this->faker->unique()->randomElement($jobTypes),
            'status' => 1
        ];
    }
}

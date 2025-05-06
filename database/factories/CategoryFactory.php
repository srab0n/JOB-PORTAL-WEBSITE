<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'status' => 1
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::where('role', 'employer')->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'title'       => fake()->jobTitle(),
            'description' => fake()->paragraphs(3, true),
            'location'    => fake()->city(),
            'type'        => fake()->randomElement(['full-time', 'part-time', 'freelance', 'internship']),
            'salary_min'  => fake()->numberBetween(20000, 50000),
            'salary_max'  => fake()->numberBetween(50000, 120000),
            'status'      => fake()->randomElement(['open', 'closed']),
        ];
    }
}
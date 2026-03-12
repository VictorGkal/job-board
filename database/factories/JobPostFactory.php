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
            'title'       => $this->faker->jobTitle(),
            'description' => $this->faker->paragraphs(3, true),
            'location'    => $this->faker->city(),
            'type'        => $this->faker->randomElement(['full-time', 'part-time', 'freelance', 'internship']),
            'salary_min'  => $this->faker->numberBetween(20000, 50000),
            'salary_max'  => $this->faker->numberBetween(50000, 120000),
            'status'      => $this->faker->randomElement(['open', 'closed']),
        ];
    }
}
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            // 'id' => rand(4,20),
            'job_type_id' => rand(1,5),
            'category_id' => rand(1,8),
            'vacancy' => rand(1,5),
            'salary' => rand(1000,5000),
            'location' => fake()->city,
            'description' => fake()->text,
            'benefits' => fake()->text,
            'experience' => rand(1,10),
            'company_name' => fake()->name,   
            'user_id' => User::factory(),         
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\WorkCategory;
use App\Models\User;

class WorkCategoryFactory extends Factory
{
    // Specify the model this factory belongs to
    protected $model = WorkCategory::class;

    public function definition(): array
    {
        return [
            // Generate a realistic category name (2 words)
            "name" => $this->faker->words(2, true),

            // Assign a user as creator; pick a random existing user or null
            "created_by" => User::inRandomOrder()->first()?->id,
        ];
    }
}

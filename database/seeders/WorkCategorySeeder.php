<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkCategory;
use App\Models\User;

class WorkCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Predefined category names
        $predefined = ["Coding", "Designing", "SEO"];

        foreach ($predefined as $categoryName) {
            // Create or get the category
            WorkCategory::firstOrCreate(
                ["name" => $categoryName],
                [
                    "created_by" => User::inRandomOrder()->first()?->id,
                ],
            );
        }

        // Create 5 additional random categories with a default name fallback
        WorkCategory::factory()
            ->count(5)
            ->create()
            ->each(function ($category, $index) {
                // Ensure unique name for each factory category
                $category->update([
                    "name" => "Category " . ($index + 1),
                ]);
            });
    }
}

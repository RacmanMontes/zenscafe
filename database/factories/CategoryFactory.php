<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected static array $usedNames = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'status' => Category::STATUS_ACTIVE,
            'description' => fake()->optional(0.5)->sentence(),
        ];
    }

    /**
     * Indicate that the category is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (): array => ['status' => Category::STATUS_ARCHIVED]);
    }
}

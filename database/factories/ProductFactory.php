<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'name' => Str::title($name),
            'slug' => Str::slug($name),
            'sku' => strtoupper(fake()->bothify('???-####')),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'unit' => fake()->randomElement(['pcs', 'kg', 'g', 'L', 'mL', 'box', 'pack']),
            'quantity' => fake()->numberBetween(0, 200),
            'min_stock' => fake()->numberBetween(5, 50),
            'max_stock' => fake()->optional(0.7)->numberBetween(100, 500),
            'cost_per_unit' => fake()->optional(0.8)->randomFloat(2, 0.5, 100),
            'status' => Product::STATUS_ACTIVE,
            'description' => fake()->optional(0.5)->sentence(),
        ];
    }

    /**
     * Indicate that the product is low on stock.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => fake()->numberBetween(1, $attributes['min_stock'] ?? 10),
            'min_stock' => $attributes['min_stock'] ?? 50,
        ]);
    }

    /**
     * Indicate that the product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
        ]);
    }

    /**
     * Indicate that the product is archived.
     */
    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Product::STATUS_ARCHIVED,
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventoryTransaction>
 */
class InventoryTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(TransactionType::values());
        $previousQuantity = fake()->numberBetween(0, 100);

        return [
            'product_id' => Product::factory(),
            'type' => $type,
            'quantity' => fake()->numberBetween(1, 20),
            'previous_quantity' => $previousQuantity,
            'new_quantity' => $previousQuantity + fake()->numberBetween(1, 20),
            'supplier_id' => $type === TransactionType::StockIn ? Supplier::factory() : null,
            'reference_number' => fake()->optional(0.6)->bothify('REF-####'),
            'reason' => $type === TransactionType::Adjustment
                ? fake()->randomElement(['Physical count correction', 'Damaged item', 'Expired item', 'Data correction', 'Initial inventory'])
                : null,
            'notes' => fake()->optional(0.4)->sentence(),
            'user_id' => User::factory(),
        ];
    }

    /**
     * Indicate a stock-in transaction.
     */
    public function stockIn(): static
    {
        return $this->state(function (array $attributes) {
            $previousQuantity = $attributes['previous_quantity'];
            $quantity = fake()->numberBetween(1, 50);

            return [
                'type' => TransactionType::StockIn,
                'quantity' => $quantity,
                'new_quantity' => $previousQuantity + $quantity,
                'supplier_id' => Supplier::factory(),
            ];
        });
    }

    /**
     * Indicate a stock-out transaction.
     */
    public function stockOut(): static
    {
        return $this->state(function (array $attributes) {
            $previousQuantity = fake()->numberBetween(10, 100);
            $quantity = fake()->numberBetween(1, $previousQuantity);

            return [
                'type' => TransactionType::StockOut,
                'quantity' => $quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $previousQuantity - $quantity,
                'supplier_id' => null,
            ];
        });
    }

    /**
     * Indicate an adjustment transaction.
     */
    public function adjustment(): static
    {
        return $this->state(function (array $attributes) {
            $previousQuantity = fake()->numberBetween(0, 100);
            $adjustment = fake()->numberBetween(-20, 20);

            return [
                'type' => TransactionType::Adjustment,
                'quantity' => abs($adjustment),
                'previous_quantity' => $previousQuantity,
                'new_quantity' => max(0, $previousQuantity + $adjustment),
                'supplier_id' => null,
                'reason' => fake()->randomElement(['Physical count correction', 'Damaged item', 'Expired item', 'Data correction', 'Initial inventory']),
            ];
        });
    }
}

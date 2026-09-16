<?php

use App\Actions\Inventory\StockOutProduct;
use App\Models\Product;
use App\Models\User;

test('staff can access stock-out page', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-out'))->assertOk();
});

test('stock out decreases product quantity', function () {
    $product = Product::factory()->create(['quantity' => 20]);

    $transaction = app(StockOutProduct::class)->execute(
        product: $product,
        quantity: 5,
        reason: 'Sale',
    );

    $this->assertEquals(15, $product->fresh()->quantity);
    $this->assertEquals(20, $transaction->previous_quantity);
    $this->assertEquals(15, $transaction->new_quantity);
});

test('stock out creates inventory transaction', function () {
    $product = Product::factory()->create(['quantity' => 20]);

    app(StockOutProduct::class)->execute(
        product: $product,
        quantity: 5,
        reason: 'Sale',
    );

    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'type' => 'stock_out',
        'quantity' => 5,
        'previous_quantity' => 20,
        'new_quantity' => 15,
    ]);
});

test('stock out cannot exceed available stock', function () {
    $product = Product::factory()->create(['quantity' => 5]);

    $this->expectException(DomainException::class);

    app(StockOutProduct::class)->execute(
        product: $product,
        quantity: 10,
    );
});

test('stock out with zero quantity throws exception', function () {
    $product = Product::factory()->create(['quantity' => 5]);

    $this->expectException(InvalidArgumentException::class);

    app(StockOutProduct::class)->execute(product: $product, quantity: 0);
});

test('stock out with exact available stock works', function () {
    $product = Product::factory()->create(['quantity' => 5]);

    app(StockOutProduct::class)->execute(
        product: $product,
        quantity: 5,
    );

    $this->assertEquals(0, $product->fresh()->quantity);
});

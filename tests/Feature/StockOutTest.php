<?php

use App\Actions\Inventory\StockOutProduct;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;

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

test('stock out that drops a product to low stock notifies verified users', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10, 'min_stock' => 5]);

    app(StockOutProduct::class)->execute(product: $product, quantity: 6);

    $this->assertDatabaseHas('notifications', [
        'type' => LowStockNotification::class,
        'notifiable_id' => $user->id,
        'notifiable_type' => User::class,
    ]);
});

test('stock out that stays above minimum stock does not notify users', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 20, 'min_stock' => 5]);

    app(StockOutProduct::class)->execute(product: $product, quantity: 5);

    expect($user->notifications()->count())->toBe(0);
});

test('stock out that keeps a product low does not duplicate notifications', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10, 'min_stock' => 5]);

    app(StockOutProduct::class)->execute(product: $product, quantity: 6);
    app(StockOutProduct::class)->execute(product: $product, quantity: 1);

    expect($user->notifications()->where('type', LowStockNotification::class)->count())->toBe(1);
});

test('low stock alerts from stock out only go to verified users', function () {
    $unverified = User::factory()->staff()->create(['email_verified_at' => null]);
    $product = Product::factory()->create(['quantity' => 10, 'min_stock' => 5]);

    app(StockOutProduct::class)->execute(product: $product, quantity: 6);

    expect($unverified->notifications()->count())->toBe(0);
});

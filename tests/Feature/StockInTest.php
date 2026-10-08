<?php

use App\Actions\Inventory\StockInProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

test('staff can access stock-in page', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-in'))->assertOk();
});

test('stock in increases product quantity', function () {
    $product = Product::factory()->create(['quantity' => 10]);
    $action = app(StockInProduct::class);

    $transaction = $action->execute(
        product: $product,
        quantity: 5,
    );

    $this->assertEquals(15, $product->fresh()->quantity);
    $this->assertEquals(10, $transaction->previous_quantity);
    $this->assertEquals(15, $transaction->new_quantity);
});

test('stock in creates inventory transaction', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    app(StockInProduct::class)->execute(product: $product, quantity: 5);

    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'type' => 'stock_in',
        'quantity' => 5,
        'previous_quantity' => 10,
        'new_quantity' => 15,
    ]);
});

test('stock in with zero quantity throws exception', function () {
    $product = Product::factory()->create();

    $this->expectException(InvalidArgumentException::class);

    app(StockInProduct::class)->execute(product: $product, quantity: 0);
});

test('stock in with negative quantity throws exception', function () {
    $product = Product::factory()->create();

    $this->expectException(InvalidArgumentException::class);

    app(StockInProduct::class)->execute(product: $product, quantity: -5);
});

test('stock in creates audit log', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    app(StockInProduct::class)->execute(product: $product, quantity: 5);

    $this->assertDatabaseHas('audit_logs', [
        'event' => 'stock_in',
        'auditable_type' => Product::class,
        'auditable_id' => $product->id,
    ]);
});

test('stock in persists the selected transacted date', function () {
    $product = Product::factory()->create(['quantity' => 10]);
    $date = Carbon::parse('2026-09-10 14:30:00');

    app(StockInProduct::class)->execute(
        product: $product,
        quantity: 5,
        transactedAt: $date,
    );

    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'transacted_at' => $date->format('Y-m-d H:i:s'),
    ]);
});

test('stock in that restores a product above minimum does not notify users', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 5, 'min_stock' => 5]);

    app(StockInProduct::class)->execute(product: $product, quantity: 10);

    expect($user->notifications()->count())->toBe(0);
});

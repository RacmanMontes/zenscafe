<?php

use App\Actions\Inventory\AdjustInventory;
use App\Models\Product;
use App\Models\User;

test('admin can access adjustment page', function () {
    $user = User::factory()->admin()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-adjustment'))->assertOk();
});

test('adjustment increases quantity with positive value', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    app(AdjustInventory::class)->execute(
        product: $product,
        adjustment: 5,
        reason: 'Physical count correction',
    );

    $this->assertEquals(15, $product->fresh()->quantity);
});

test('adjustment decreases quantity with negative value', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    app(AdjustInventory::class)->execute(
        product: $product,
        adjustment: -3,
        reason: 'Damaged item',
    );

    $this->assertEquals(7, $product->fresh()->quantity);
});

test('adjustment cannot result in negative stock', function () {
    $product = Product::factory()->create(['quantity' => 5]);

    $this->expectException(DomainException::class);

    app(AdjustInventory::class)->execute(
        product: $product,
        adjustment: -10,
        reason: 'Data correction',
    );
});

test('adjustment creates inventory transaction', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    app(AdjustInventory::class)->execute(
        product: $product,
        adjustment: 5,
        reason: 'Physical count correction',
    );

    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'type' => 'adjustment',
        'previous_quantity' => 10,
        'new_quantity' => 15,
        'reason' => 'Physical count correction',
    ]);
});

test('adjustment creates audit log', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    app(AdjustInventory::class)->execute(
        product: $product,
        adjustment: 5,
        reason: 'Physical count correction',
    );

    $this->assertDatabaseHas('audit_logs', [
        'event' => 'adjustment',
        'auditable_type' => Product::class,
        'auditable_id' => $product->id,
    ]);
});

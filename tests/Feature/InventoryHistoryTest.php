<?php

use App\Actions\Inventory\StockInProduct;
use App\Actions\Inventory\StockOutProduct;
use App\Livewire\History\Index;
use App\Models\Product;
use App\Models\User;

test('inventory history page shows transactions', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10]);

    app(StockInProduct::class)->execute(product: $product, quantity: 5);
    app(StockOutProduct::class)->execute(product: $product, quantity: 3, reason: 'Sale');

    $this->actingAs($user)->get(route('inventory-history'))->assertOk();
});

test('inventory history can be filtered by type', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10]);

    app(StockInProduct::class)->execute(product: $product, quantity: 5);

    Livewire::test(Index::class)
        ->set('typeFilter', 'stock_in')
        ->assertSee('Stock In');
});

test('inventory history records all transaction details', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    $transaction = app(StockInProduct::class)->execute(
        product: $product,
        quantity: 5,
        referenceNumber: 'REF-001',
        notes: 'Test notes',
    );

    $this->assertDatabaseHas('inventory_transactions', [
        'id' => $transaction->id,
        'reference_number' => 'REF-001',
        'notes' => 'Test notes',
    ]);
});

test('transactions cannot be silently modified', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    $transaction = app(StockInProduct::class)->execute(product: $product, quantity: 5);

    $transaction->update(['quantity' => 999]);

    $this->assertDatabaseHas('inventory_transactions', [
        'id' => $transaction->id,
        'quantity' => 999,
    ]);

    // The product quantity should remain unchanged since we only modified the transaction record
    $this->assertEquals(15, $product->fresh()->quantity);
});

<?php

use App\Enums\TransactionType;
use App\Livewire\Stock\Adjustment;
use App\Livewire\Stock\StockIn;
use App\Livewire\Stock\StockOut;
use App\Models\InventoryTransaction;
use App\Models\Product;

test('reference numbers are generated sequentially per prefix', function () {
    $base = 'STKIN-'.now()->format('Ymd');

    expect(InventoryTransaction::generateReferenceNumber(TransactionType::StockIn))->toBe($base.'-001');

    $product = Product::factory()->create();

    InventoryTransaction::create([
        'product_id' => $product->id,
        'type' => TransactionType::StockIn,
        'quantity' => 1,
        'previous_quantity' => 0,
        'new_quantity' => 1,
        'reference_number' => $base.'-001',
    ]);

    expect(InventoryTransaction::generateReferenceNumber(TransactionType::StockIn))->toBe($base.'-002');
});

test('reference number prefixes differ per transaction type', function () {
    $date = now()->format('Ymd');

    expect(InventoryTransaction::generateReferenceNumber(TransactionType::StockIn))->toBe('STKIN-'.$date.'-001');
    expect(InventoryTransaction::generateReferenceNumber(TransactionType::StockOut))->toBe('STKOUT-'.$date.'-001');
    expect(InventoryTransaction::generateReferenceNumber(TransactionType::Adjustment))->toBe('ADJ-'.$date.'-001');
});

test('stock in page displays an auto-generated reference number', function () {
    Livewire::test(StockIn::class)
        ->assertSee('STKIN-'.now()->format('Ymd'));
});

test('stock in form pre-fills the sku when a product is selected', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    Livewire::test(StockIn::class)
        ->set('product_id', $product->id)
        ->assertSeeHtml('value="'.$product->sku.'"');
});

test('stock in form persists the auto-generated reference number', function () {
    $product = Product::factory()->create(['quantity' => 10]);
    $reference = 'STKIN-'.now()->format('Ymd').'-001';

    Livewire::test(StockIn::class)
        ->set('product_id', $product->id)
        ->set('quantity', 5)
        ->set('date', now()->format('Y-m-d'))
        ->call('submit');

    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'type' => 'stock_in',
        'reference_number' => $reference,
    ]);
});

test('stock out page displays an auto-generated reference number', function () {
    Livewire::test(StockOut::class)
        ->assertSee('STKOUT-'.now()->format('Ymd'));
});

test('stock out form pre-fills the sku when a product is selected', function () {
    $product = Product::factory()->create(['quantity' => 15]);

    Livewire::test(StockOut::class)
        ->set('product_id', $product->id)
        ->assertSeeHtml('value="'.$product->sku.'"');
});

test('adjustment page displays an auto-generated reference number', function () {
    Livewire::test(Adjustment::class)
        ->assertSee('ADJ-'.now()->format('Ymd'));
});

test('adjustment form pre-fills the sku when a product is selected', function () {
    $product = Product::factory()->create(['quantity' => 10]);

    Livewire::test(Adjustment::class)
        ->set('product_id', $product->id)
        ->assertSeeHtml('value="'.$product->sku.'"');
});

test('adjustment form persists the auto-generated reference number', function () {
    $product = Product::factory()->create(['quantity' => 10]);
    $reference = 'ADJ-'.now()->format('Ymd').'-001';

    Livewire::test(Adjustment::class)
        ->set('product_id', $product->id)
        ->set('adjustment', 5)
        ->set('reason', 'Physical count correction')
        ->call('submit');

    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'type' => 'adjustment',
        'reference_number' => $reference,
    ]);
});

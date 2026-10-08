<?php

use App\Livewire\Stock\Adjustment;
use App\Livewire\Stock\StockIn;
use App\Livewire\Stock\StockOut;
use App\Models\Product;
use App\Models\User;
use App\Services\QrCodeRenderer;

test('qr renderer produces svg markup', function () {
    $svg = app(QrCodeRenderer::class)->render('SKU-TEST');

    expect($svg)->toContain('<svg');
});

test('product show page renders a scan qr code', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create();

    $this->actingAs($admin)
        ->get(route('products.show', $product))
        ->assertOk()
        ->assertSee('<svg', false);
});

test('stock in scan selects the matching product and clears the scan field', function () {
    $product = Product::factory()->create(['quantity' => 10, 'sku' => 'SCAN-001']);

    Livewire::test(StockIn::class)
        ->set('scan', $product->sku)
        ->call('handleScan')
        ->assertSet('product_id', $product->id)
        ->assertSet('scan', '');
});

test('stock in scan with unknown sku adds an error and selects nothing', function () {
    Product::factory()->create(['quantity' => 10, 'sku' => 'SCAN-001']);

    Livewire::test(StockIn::class)
        ->set('scan', 'MISSING-999')
        ->call('handleScan')
        ->assertHasErrors(['scan'])
        ->assertSet('product_id', null);
});

test('stock out scan selects the matching product', function () {
    $product = Product::factory()->create(['quantity' => 15, 'sku' => 'SCAN-002']);

    Livewire::test(StockOut::class)
        ->set('scan', $product->sku)
        ->call('handleScan')
        ->assertSet('product_id', $product->id);
});

test('adjustment scan selects the matching product', function () {
    $product = Product::factory()->create(['quantity' => 10, 'sku' => 'SCAN-003']);

    Livewire::test(Adjustment::class)
        ->set('scan', $product->sku)
        ->call('handleScan')
        ->assertSet('product_id', $product->id);
});

test('scan resolves the stable qr payload by product id', function () {
    $product = Product::factory()->create(['quantity' => 10, 'sku' => 'SCAN-004']);

    expect(Product::resolveByScan('ZC:'.$product->id)->id)->toBe($product->id);

    Livewire::test(StockIn::class)
        ->set('scan', 'ZC:'.$product->id)
        ->call('handleScan')
        ->assertSet('product_id', $product->id);
});

test('scan with an unknown product id in qr payload adds an error', function () {
    Product::factory()->create(['quantity' => 10]);

    Livewire::test(StockIn::class)
        ->set('scan', 'ZC:999999')
        ->call('handleScan')
        ->assertHasErrors(['scan'])
        ->assertSet('product_id', null);
});

test('scan does not match archived products', function () {
    $product = Product::factory()->archived()->create(['quantity' => 10, 'sku' => 'GHOST-001']);

    expect(Product::resolveByScan('GHOST-001'))->toBeNull();
    expect(Product::resolveByScan('ZC:'.$product->id))->toBeNull();
});

<?php

use App\Actions\Inventory\StockInProduct;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

test('staff can view a supplier with order history', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->create();
    $product = Product::factory()->create(['supplier_id' => $supplier->id]);

    app(StockInProduct::class)->execute(
        product: $product,
        quantity: 12,
        supplierId: $supplier->id,
        referenceNumber: 'PO-1001',
    );

    $this->actingAs($user)->get(route('suppliers.show', $supplier))
        ->assertOk()
        ->assertSee($product->name)
        ->assertSee('PO-1001');
});

test('archived supplier details return 404', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->archived()->create();

    $this->actingAs($user)->get(route('suppliers.show', $supplier))->assertNotFound();
});

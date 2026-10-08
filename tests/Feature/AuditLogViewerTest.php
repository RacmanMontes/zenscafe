<?php

use App\Actions\Inventory\StockInProduct;
use App\Models\Product;
use App\Models\User;

test('staff cannot access the audit logs page', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('audit-logs'))->assertForbidden();
});

test('admin can view audit log entries', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10]);

    app(StockInProduct::class)->execute(product: $product, quantity: 5);

    $this->actingAs($admin)->get(route('audit-logs'))
        ->assertOk()
        ->assertSee('stock_in');
});

<?php

use App\Models\Product;
use App\Models\User;

test('low stock product is correctly identified', function () {
    $product = Product::factory()->create(['quantity' => 5, 'min_stock' => 10]);

    expect($product->isLowStock())->toBeTrue();
    expect($product->isOutOfStock())->toBeFalse();
});

test('out of stock product is correctly identified', function () {
    $product = Product::factory()->create(['quantity' => 0]);

    expect($product->isOutOfStock())->toBeTrue();
    expect($product->isLowStock())->toBeFalse();
});

test('in stock product is correctly identified', function () {
    $product = Product::factory()->create(['quantity' => 20, 'min_stock' => 10]);

    expect($product->isOutOfStock())->toBeFalse();
    expect($product->isLowStock())->toBeFalse();
});

test('low stock scope returns correct products', function () {
    Product::factory()->create(['quantity' => 5, 'min_stock' => 10]);
    Product::factory()->create(['quantity' => 20, 'min_stock' => 10]);
    Product::factory()->create(['quantity' => 0, 'min_stock' => 10]);

    $lowStock = Product::lowStock()->get();

    expect($lowStock)->toHaveCount(1);
    expect($lowStock->first()->quantity)->toBe(5);
});

test('out of stock scope returns correct products', function () {
    Product::factory()->create(['quantity' => 0]);
    Product::factory()->create(['quantity' => 5]);
    Product::factory()->create(['quantity' => 0]);

    $outOfStock = Product::outOfStock()->get();

    expect($outOfStock)->toHaveCount(2);
});

test('dashboard shows correct low stock count', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    Product::factory()->create(['quantity' => 3, 'min_stock' => 10]);
    Product::factory()->create(['quantity' => 20, 'min_stock' => 10]);
    Product::factory()->create(['quantity' => 0, 'min_stock' => 10]);

    $this->actingAs($user)->get(route('dashboard'))->assertOk();
});

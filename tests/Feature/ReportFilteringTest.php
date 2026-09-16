<?php

use App\Livewire\Reports\CurrentInventory;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('staff can access reports index', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('reports'))->assertOk();
});

test('staff can access current inventory report', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('reports.current-inventory'))->assertOk();
});

test('staff can access low stock report', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('reports.low-stock'))->assertOk();
});

test('staff can access stock movement report', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('reports.stock-movement'))->assertOk();
});

test('current inventory report can be filtered by category', function () {
    $category = Category::factory()->create();
    $product = Product::factory()->create(['category_id' => $category->id]);

    Livewire::test(CurrentInventory::class)
        ->set('category_id', $category->id)
        ->assertSee($product->name);
});

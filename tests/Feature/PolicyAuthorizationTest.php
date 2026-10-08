<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

test('staff and admin are granted product permissions', function () {
    $staff = User::factory()->staff()->create();
    $admin = User::factory()->admin()->create();
    $product = Product::factory()->create();

    expect(Gate::forUser($staff)->allows('delete', $product))->toBeTrue();
    expect(Gate::forUser($admin)->allows('delete', $product))->toBeTrue();
});

test('users without a role are denied inventory permissions', function () {
    $anonymous = new User;
    $product = Product::factory()->create();
    $category = Category::factory()->create();
    $supplier = Supplier::factory()->create();

    expect(Gate::forUser($anonymous)->allows('viewAny', Product::class))->toBeFalse();
    expect(Gate::forUser($anonymous)->allows('delete', $product))->toBeFalse();
    expect(Gate::forUser($anonymous)->allows('delete', $category))->toBeFalse();
    expect(Gate::forUser($anonymous)->allows('delete', $supplier))->toBeFalse();
});

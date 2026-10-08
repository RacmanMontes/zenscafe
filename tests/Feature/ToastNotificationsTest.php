<?php

use App\Livewire\Categories\Index as CategoryIndex;
use App\Livewire\Stock\Adjustment;
use App\Livewire\Stock\StockIn;
use App\Livewire\Stock\StockOut;
use App\Livewire\Suppliers\Index as SupplierIndex;
use App\Livewire\Users\Index as UserIndex;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Livewire;

test('app layout surfaces session flashes through the toast dispatcher', function () {
    $user = User::factory()->admin()->create(['email_verified_at' => now()]);

    $this->actingAs($user)
        ->withSession(['success' => 'Toast dispatcher smoke test 481516'])
        ->get(route('products.index'))
        ->assertOk()
        ->assertSee('toastNotifications', false)
        ->assertSee('Toast dispatcher smoke test 481516', false);
});

test('archiving a category dispatches a success toast', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();

    Livewire::actingAs($user)->test(CategoryIndex::class)
        ->call('confirmArchive', $category->id)
        ->call('archive')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Category archived successfully.');
});

test('archiving a category with products dispatches a danger toast', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();
    Product::factory()->create(['category_id' => $category->id]);

    Livewire::actingAs($user)->test(CategoryIndex::class)
        ->call('confirmArchive', $category->id)
        ->call('archive')
        ->assertDispatched('zenscafe-toast', variant: 'danger');
});

test('archiving a supplier dispatches a success toast', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->create();

    Livewire::actingAs($user)->test(SupplierIndex::class)
        ->call('confirmArchive', $supplier->id)
        ->call('archive')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Supplier archived successfully.');
});

test('self-deactivation dispatches a danger toast', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);

    Livewire::actingAs($admin)->test(UserIndex::class)
        ->call('toggleStatus', $admin->id)
        ->assertDispatched('zenscafe-toast', variant: 'danger', title: 'Error', text: 'You cannot deactivate your own account.');
});

test('stock in dispatches a success toast', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10]);

    Livewire::actingAs($user)->test(StockIn::class)
        ->set('product_id', $product->id)
        ->set('quantity', 5)
        ->set('date', Carbon::now()->format('Y-m-d'))
        ->call('submit')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Stock in recorded successfully. New quantity: 15');
});

test('stock out dispatches a success toast', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10]);

    Livewire::actingAs($user)->test(StockOut::class)
        ->set('product_id', $product->id)
        ->set('quantity', 4)
        ->set('date', Carbon::now()->format('Y-m-d'))
        ->call('submit')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Stock out recorded successfully. New quantity: 6');
});

test('inventory adjustment dispatches a success toast', function () {
    $user = User::factory()->admin()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10]);

    Livewire::actingAs($user)->test(Adjustment::class)
        ->set('product_id', $product->id)
        ->set('adjustment', -2)
        ->set('reason', 'Damaged item')
        ->call('submit')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Inventory adjusted successfully. New quantity: 8');
});

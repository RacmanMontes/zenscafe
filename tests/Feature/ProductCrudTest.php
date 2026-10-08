<?php

use App\Actions\Inventory\StockInProduct;
use App\Actions\Product\ArchiveProduct;
use App\Actions\Product\CreateProduct;
use App\Livewire\Products\Create;
use App\Livewire\Products\Edit;
use App\Livewire\Products\Index;
use App\Livewire\Products\Show;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('staff can view products list', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    Product::factory()->count(3)->create();

    $this->actingAs($user)->get(route('products.index'))->assertOk();
});

test('staff can view a product', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create();

    $this->actingAs($user)->get(route('products.show', $product))->assertOk();
});

test('staff can create a product via livewire', function () {
    $category = Category::factory()->create();

    Livewire::test(Create::class)
        ->set('name', 'Test Product')
        ->set('sku', 'TEST-001')
        ->set('category_id', $category->id)
        ->set('unit', 'pcs')
        ->set('quantity', 10)
        ->set('min_stock', 5)
        ->set('status', 'active')
        ->call('save')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Product created successfully.');

    $this->assertDatabaseHas('products', ['name' => 'Test Product', 'sku' => 'TEST-001']);
});

test('product create page was replaced by an inline modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get('/products/create')->assertNotFound();
});

test('staff can open the create product modal from the index', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true);
});

test('products index opens the create modal via the create query param', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->withQueryParams(['create' => 1])->test(Index::class)
        ->assertSet('showCreateModal', true)
        ->assertSee('Add New Product');
});

test('creating a product closes the create modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true)
        ->dispatch('productCreated')
        ->assertSet('showCreateModal', false);
});

test('staff can update a product via livewire', function () {
    $product = Product::factory()->create();

    Livewire::test(Edit::class, ['product' => $product])
        ->set('name', 'Updated Product')
        ->set('sku', $product->sku)
        ->set('category_id', $product->category_id)
        ->set('unit', 'pcs')
        ->set('quantity', $product->quantity)
        ->set('min_stock', $product->min_stock)
        ->set('status', 'active')
        ->call('save');

    $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'Updated Product']);
});

test('product sku must be unique', function () {
    Product::factory()->create(['sku' => 'UNIQUE-001']);

    Livewire::test(Create::class)
        ->set('name', 'Test')
        ->set('sku', 'UNIQUE-001')
        ->set('category_id', Category::factory()->create()->id)
        ->set('unit', 'pcs')
        ->set('quantity', 0)
        ->set('min_stock', 0)
        ->call('save')
        ->assertHasErrors(['sku']);
});

test('create product action creates audit log', function () {
    $category = Category::factory()->create();
    $action = app(CreateProduct::class);

    $product = $action->execute(
        data: ['name' => 'Audit Test', 'sku' => 'AUD-001', 'category_id' => $category->id, 'unit' => 'pcs', 'quantity' => 0, 'min_stock' => 0, 'status' => 'active'],
    );

    $this->assertDatabaseHas('audit_logs', [
        'event' => 'created',
        'auditable_type' => Product::class,
        'auditable_id' => $product->id,
    ]);
});

test('archive product action changes status and creates audit log', function () {
    $product = Product::factory()->create(['status' => 'active']);
    $action = app(ArchiveProduct::class);

    $action->execute($product);

    $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'archived']);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'archived',
        'auditable_type' => Product::class,
        'auditable_id' => $product->id,
    ]);
});

test('staff can archive a product via livewire', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['status' => 'active']);

    Livewire::actingAs($user)->test(Show::class, ['product' => $product])
        ->call('archive');

    $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'archived']);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'archived',
        'auditable_type' => Product::class,
        'auditable_id' => $product->id,
    ]);
});

test('archived product does not appear in active product lists', function () {
    $active = Product::factory()->create(['status' => 'active']);
    $archived = Product::factory()->create(['status' => 'archived']);

    $this->assertDatabaseHas('products', ['id' => $active->id, 'status' => 'active']);
    $this->assertDatabaseHas('products', ['id' => $archived->id, 'status' => 'archived']);

    $activeProducts = Product::where('status', 'active')->pluck('id');
    $this->assertTrue($activeProducts->contains($active->id));
    $this->assertFalse($activeProducts->contains($archived->id));
});

test('archived product retains inventory transactions', function () {
    $product = Product::factory()->create(['status' => 'active', 'quantity' => 10]);

    app(StockInProduct::class)->execute(product: $product, quantity: 5);

    app(ArchiveProduct::class)->execute($product);

    $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'archived']);
    $this->assertDatabaseHas('inventory_transactions', [
        'product_id' => $product->id,
        'type' => 'stock_in',
        'quantity' => 5,
    ]);
});

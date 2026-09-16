<?php

use App\Actions\Category\ArchiveCategory;
use App\Livewire\Categories\Create;
use App\Livewire\Categories\Edit;
use App\Livewire\Categories\Index;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('staff can view categories list', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('categories.index'))->assertOk();
});

test('staff can create a category via livewire', function () {
    Livewire::test(Create::class)
        ->set('name', 'Test Category')
        ->set('description', 'A test category')
        ->call('save');

    $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
});

test('staff can update a category via livewire', function () {
    $category = Category::factory()->create();

    Livewire::test(Edit::class, ['category' => $category])
        ->set('name', 'Updated Category')
        ->call('save');

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'name' => 'Updated Category']);
});

test('category name must be unique', function () {
    Category::factory()->create(['name' => 'Existing Category']);

    Livewire::test(Create::class)
        ->set('name', 'Existing Category')
        ->call('save')
        ->assertHasErrors(['name']);
});

test('cannot archive category with products', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();
    Product::factory()->create(['category_id' => $category->id]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('confirmArchive', $category->id)
        ->call('archive');

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'deleted_at' => null]);
});

test('can archive empty category via livewire', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->call('confirmArchive', $category->id)
        ->call('archive');

    $this->assertSoftDeleted('categories', ['id' => $category->id]);
});

test('archive category action creates audit log', function () {
    $category = Category::factory()->create();
    $action = app(ArchiveCategory::class);

    $action->execute($category);

    $this->assertSoftDeleted('categories', ['id' => $category->id]);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'archived',
        'auditable_type' => Category::class,
        'auditable_id' => $category->id,
    ]);
});

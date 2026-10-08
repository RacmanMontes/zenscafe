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
        ->call('save')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Category created successfully.');

    $this->assertDatabaseHas('categories', ['name' => 'Test Category']);
});

test('category create page was replaced by an inline modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get('/categories/create')->assertNotFound();
});

test('staff can open the create category modal from the index', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true);
});

test('creating a category closes the create modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true)
        ->dispatch('categoryCreated')
        ->assertSet('showCreateModal', false);
});

test('category edit page was replaced by an inline modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();

    $this->actingAs($user)->get("/categories/{$category->id}/edit")->assertNotFound();
});

test('staff can open the edit category modal from the index', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->call('openEditModal', $category->id)
        ->assertSet('showEditModal', true)
        ->assertSet('editingCategoryId', $category->id);
});

test('updating a category closes the edit modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->call('openEditModal', $category->id)
        ->assertSet('showEditModal', true)
        ->dispatch('categoryUpdated')
        ->assertSet('showEditModal', false)
        ->assertSet('editingCategoryId', null);
});

test('staff can update a category via livewire', function () {
    $category = Category::factory()->create();

    Livewire::test(Edit::class, ['category' => $category])
        ->set('name', 'Updated Category')
        ->call('save')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Category updated successfully.');

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

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'status' => 'active']);
});

test('can archive empty category via livewire', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->call('confirmArchive', $category->id)
        ->call('archive');

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'status' => 'archived']);
});

test('archive category action creates audit log', function () {
    $category = Category::factory()->create();
    $action = app(ArchiveCategory::class);

    $action->execute($category);

    $this->assertDatabaseHas('categories', ['id' => $category->id, 'status' => 'archived']);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'archived',
        'auditable_type' => Category::class,
        'auditable_id' => $category->id,
    ]);
});

test('archived categories are hidden from the active list', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->archived()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->assertDontSee($category->name);
});

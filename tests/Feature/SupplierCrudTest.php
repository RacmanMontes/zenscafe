<?php

use App\Actions\Supplier\ArchiveSupplier;
use App\Livewire\Suppliers\Create;
use App\Livewire\Suppliers\Edit;
use App\Livewire\Suppliers\Index;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;

test('staff can view suppliers list', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('suppliers.index'))->assertOk();
});

test('staff can create a supplier via livewire', function () {
    Livewire::test(Create::class)
        ->set('name', 'Test Supplier')
        ->set('contact_person', 'John Doe')
        ->set('email', 'john@test.com')
        ->set('phone', '555-0000')
        ->call('save')
        ->assertDispatched('zenscafe-toast', variant: 'success', title: 'Success', text: 'Supplier created successfully.');

    $this->assertDatabaseHas('suppliers', ['name' => 'Test Supplier']);
});

test('supplier create page was replaced by an inline modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get('/suppliers/create')->assertNotFound();
});

test('staff can open the create supplier modal from the index', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true);
});

test('creating a supplier closes the create modal', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('openCreateModal')
        ->assertSet('showCreateModal', true)
        ->dispatch('supplierCreated')
        ->assertSet('showCreateModal', false);
});

test('staff can update a supplier via livewire', function () {
    $supplier = Supplier::factory()->create();

    Livewire::test(Edit::class, ['supplier' => $supplier])
        ->set('name', 'Updated Supplier')
        ->call('save');

    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'name' => 'Updated Supplier']);
});

test('cannot archive supplier with products', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->create();
    Product::factory()->create(['supplier_id' => $supplier->id]);

    Livewire::actingAs($user)->test(Index::class)
        ->call('confirmArchive', $supplier->id)
        ->call('archive');

    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'status' => 'active']);
});

test('can archive empty supplier via livewire', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->call('confirmArchive', $supplier->id)
        ->call('archive');

    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'status' => 'archived']);
});

test('archive supplier action creates audit log', function () {
    $supplier = Supplier::factory()->create();
    $action = app(ArchiveSupplier::class);

    $action->execute($supplier);

    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'status' => 'archived']);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'archived',
        'auditable_type' => Supplier::class,
        'auditable_id' => $supplier->id,
    ]);
});

test('archived suppliers are hidden from the active list', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->archived()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->assertDontSee($supplier->name);
});

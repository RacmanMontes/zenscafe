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
        ->call('save');

    $this->assertDatabaseHas('suppliers', ['name' => 'Test Supplier']);
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

    $this->assertDatabaseHas('suppliers', ['id' => $supplier->id, 'deleted_at' => null]);
});

test('can archive empty supplier via livewire', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $supplier = Supplier::factory()->create();

    Livewire::actingAs($user)->test(Index::class)
        ->call('confirmArchive', $supplier->id)
        ->call('archive');

    $this->assertSoftDeleted('suppliers', ['id' => $supplier->id]);
});

test('archive supplier action creates audit log', function () {
    $supplier = Supplier::factory()->create();
    $action = app(ArchiveSupplier::class);

    $action->execute($supplier);

    $this->assertSoftDeleted('suppliers', ['id' => $supplier->id]);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'archived',
        'auditable_type' => Supplier::class,
        'auditable_id' => $supplier->id,
    ]);
});

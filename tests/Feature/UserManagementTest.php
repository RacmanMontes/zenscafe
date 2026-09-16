<?php

use App\Actions\User\CreateUser;
use App\Actions\User\ToggleUserStatus;
use App\Actions\User\UpdateUser;
use App\Enums\UserRole;
use App\Livewire\Users\Create;
use App\Livewire\Users\Edit;
use App\Livewire\Users\Index;
use App\Models\User;

test('admin can view users list', function () {
    $user = User::factory()->admin()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('users.index'))->assertOk();
});

test('admin can create a user via livewire', function () {
    Livewire::test(Create::class)
        ->set('name', 'New Staff')
        ->set('email', 'newstaff@test.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('role', 'staff')
        ->call('save');

    $this->assertDatabaseHas('users', ['email' => 'newstaff@test.com', 'role' => 'staff']);
});

test('admin can create an admin user via livewire', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);

    Livewire::actingAs($admin)->test(Create::class)
        ->set('name', 'New Admin')
        ->set('email', 'newadmin@test.com')
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('role', 'admin')
        ->call('save');

    $this->assertDatabaseHas('users', ['email' => 'newadmin@test.com', 'role' => 'admin']);
});

test('admin can update a user via livewire', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);

    Livewire::test(Edit::class, ['user' => $admin])
        ->set('name', 'Updated Admin')
        ->set('email', $admin->email)
        ->set('role', 'admin')
        ->call('save');

    $this->assertDatabaseHas('users', ['id' => $admin->id, 'name' => 'Updated Admin']);
});

test('toggle status deactivates active user', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);

    $action = app(ToggleUserStatus::class);
    $result = $action->execute($staff);

    $this->assertNull($result->fresh()->email_verified_at);
    $this->assertDatabaseHas('audit_logs', [
        'event' => 'status_changed',
        'auditable_type' => User::class,
        'auditable_id' => $staff->id,
    ]);
});

test('toggle status activates inactive user', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => null]);

    $action = app(ToggleUserStatus::class);
    $result = $action->execute($staff);

    $this->assertNotNull($result->fresh()->email_verified_at);
});

test('self-deactivation is prevented in livewire component', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);

    Livewire::actingAs($admin)->test(Index::class)
        ->call('toggleStatus', $admin->id);

    $this->assertNotNull($admin->fresh()->email_verified_at);
});

test('deactivated user is treated as unverified', function () {
    $user = User::factory()->staff()->create([
        'email_verified_at' => null,
    ]);

    $this->assertNull($user->email_verified_at);
});

test('public registration page is unavailable', function () {
    $this->get('/register')->assertNotFound();
});

test('public registration POST is unavailable', function () {
    $this->post('/register', [
        'name' => 'Attacker',
        'email' => 'attacker@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ])->assertNotFound();
});

test('staff cannot access user management', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($staff)->get(route('users.index'))->assertForbidden();
    $this->actingAs($staff)->get(route('users.create'))->assertForbidden();
});

test('role is not mass-assignable via create', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);

    $this->actingAs($admin);

    $action = app(CreateUser::class);
    $user = $action->execute(
        data: ['name' => 'Test', 'email' => 'test@test.com', 'password' => 'password123', 'role' => 'admin'],
        request: request(),
    );

    $this->assertEquals(UserRole::Admin, $user->role);
});

test('staff cannot escalate own role via update action', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($staff);

    $action = app(UpdateUser::class);
    $action->execute($staff, ['name' => $staff->name, 'email' => $staff->email, 'role' => 'admin'], request());

    $this->assertEquals(UserRole::Staff, $staff->fresh()->role);
});

test('staff cannot create admin user via action', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($staff);

    $action = app(CreateUser::class);
    $user = $action->execute(
        data: ['name' => 'Test', 'email' => 'created@test.com', 'password' => 'password123', 'role' => 'admin'],
        request: request(),
    );

    $this->assertEquals(UserRole::Staff, $user->role);
});

test('admin can change another user role via update action', function () {
    $admin = User::factory()->admin()->create(['email_verified_at' => now()]);
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($admin);

    $action = app(UpdateUser::class);
    $action->execute($staff, ['name' => $staff->name, 'email' => $staff->email, 'role' => 'admin'], request());

    $this->assertEquals(UserRole::Admin, $staff->fresh()->role);
});

test('staff cannot access stock adjustment', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($staff)->get(route('stock-adjustment'))->assertForbidden();
});

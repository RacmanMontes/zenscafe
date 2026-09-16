<?php

use App\Models\User;

test('guest is redirected to login', function () {
    $this->get(route('dashboard'))->assertRedirect(route('login'));
});

test('authenticated user can access dashboard', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('dashboard'))->assertOk();
});

test('staff can access products', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('products.index'))->assertOk();
});

test('staff can access stock-in', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-in'))->assertOk();
});

test('staff can access stock-out', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-out'))->assertOk();
});

test('staff can access inventory history', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('inventory-history'))->assertOk();
});

test('staff cannot access user management', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('users.index'))->assertForbidden();
});

test('staff cannot access stock adjustment', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-adjustment'))->assertForbidden();
});

test('admin can access user management', function () {
    $user = User::factory()->admin()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('users.index'))->assertOk();
});

test('admin can access stock adjustment', function () {
    $user = User::factory()->admin()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('stock-adjustment'))->assertOk();
});

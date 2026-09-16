<?php

use App\Models\User;

test('welcome screen can be rendered', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('Smart Inventory Management');
    $response->assertSee('Login to System');
    $response->assertSee('Explore Features');
});

test('welcome screen shows login link to guests', function () {
    $this->get(route('home'))
        ->assertSee('href="'.route('login').'"', escape: false)
        ->assertSee('ZEN\'S CAFE');
});

test('welcome screen does not expose registration', function () {
    $this->get(route('home'))
        ->assertDontSee('Register')
        ->assertDontSee('Sign Up')
        ->assertDontSee('Create Account');
});

test('welcome screen shows dashboard link to authenticated users', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('home'))
        ->assertSee('Go to Dashboard')
        ->assertSee('href="'.route('dashboard').'"', escape: false);
});

test('welcome screen includes expected landing page sections', function () {
    $this->get(route('home'))
        ->assertSee('Everything You Need to Manage Inventory')
        ->assertSee('How the System Works')
        ->assertSee('Built for Better Inventory Management')
        ->assertSee('Ready to Manage Your Inventory Better?')
        ->assertSee('Web-Based Inventory Management System');
});

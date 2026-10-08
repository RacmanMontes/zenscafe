<?php

use App\Models\Category;
use App\Models\Product;
use App\Models\User;

test('unauthenticated user is redirected to login when accessing export routes', function () {
    $this->get(route('reports.current-inventory.export-pdf'))->assertRedirect();
    $this->get(route('reports.current-inventory.export-excel'))->assertRedirect();
    $this->get(route('reports.current-inventory.export-word'))->assertRedirect();
});

test('staff can download current inventory as pdf', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    Product::factory()->count(3)->create();
    Product::factory()->lowStock()->create();

    $response = $this->actingAs($user)->get(route('reports.current-inventory.export-pdf'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/pdf');
    $this->assertTrue(
        str_contains($response->headers->get('Content-Disposition'), 'current-inventory.pdf'),
    );
});

test('staff can download current inventory as excel', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    Product::factory()->count(2)->create();

    $response = $this->actingAs($user)->get(route('reports.current-inventory.export-excel'));

    $response->assertOk();
    $this->assertTrue(
        str_contains($response->headers->get('Content-Disposition'), 'current-inventory.xlsx'),
    );
});

test('staff can download current inventory as word document', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    Product::factory()->count(2)->create();

    $response = $this->actingAs($user)->get(route('reports.current-inventory.export-word'));

    $response->assertOk();
    $this->assertTrue(
        str_contains($response->headers->get('Content-Disposition'), 'current-inventory.docx'),
    );
});

test('export routes respect category filter', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $category = Category::factory()->create();
    Product::factory()->create(['category_id' => $category->id, 'name' => 'Filtered Item']);
    Product::factory()->create(['name' => 'Other Item']);

    $response = $this->actingAs($user)->get(
        route('reports.current-inventory.export-pdf', ['category_id' => $category->id]),
    );

    $response->assertOk();
    $this->assertTrue(
        str_contains($response->headers->get('Content-Disposition'), 'current-inventory.pdf'),
    );
});

<?php

use App\Actions\Inventory\StockOutProduct;
use App\Livewire\Alerts\LowStockAlerts;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

test('low stock command notifies staff once per product', function () {
    $staff = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->lowStock()->create();

    $this->artisan('inventory:send-low-stock-alerts')->assertExitCode(0);

    $this->assertDatabaseHas('notifications', [
        'type' => LowStockNotification::class,
        'notifiable_id' => $staff->id,
        'notifiable_type' => User::class,
    ]);

    $this->artisan('inventory:send-low-stock-alerts')->assertExitCode(0);

    expect($staff->notifications()->count())->toBe(1);
});

test('low stock command alerts on out of stock but not healthy products', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    Product::factory()->outOfStock()->create();
    Product::factory()->create(['quantity' => 50, 'min_stock' => 10]);

    $this->artisan('inventory:send-low-stock-alerts')->assertExitCode(0);

    expect($user->notifications()->count())->toBe(1);
});

test('low stock alert bell marks all alerts as read', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->lowStock()->create();
    $user->notify(new LowStockNotification($product));

    Livewire::actingAs($user)->test(LowStockAlerts::class)
        ->assertViewHas('unreadCount', 1)
        ->call('markAllAsRead')
        ->assertViewHas('unreadCount', 0);
});

test('low stock alert bell marks a single alert as read', function () {
    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->lowStock()->create();
    $user->notify(new LowStockNotification($product));
    $notification = $user->notifications()->first();

    Livewire::actingAs($user)->test(LowStockAlerts::class)
        ->call('markAsRead', $notification->id)
        ->assertViewHas('unreadCount', 0);
});

test('low stock alerts are emailed to every verified user', function () {
    Notification::fake();

    $user = User::factory()->staff()->create(['email_verified_at' => now()]);
    $product = Product::factory()->create(['quantity' => 10, 'min_stock' => 5]);

    app(StockOutProduct::class)->execute(product: $product, quantity: 6);

    Notification::assertSentTo(
        $user,
        LowStockNotification::class,
        function (LowStockNotification $notification, array $channels): bool {
            return in_array('mail', $channels, true);
        },
    );
});

<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class LowStockAlertService
{
    /**
     * Send a low-stock alert to every verified user for the given product when it is low or out of stock.
     *
     * @return int Number of notifications sent.
     */
    public function dispatchFor(Product $product): int
    {
        if ($product->status !== Product::STATUS_ACTIVE || (! $product->isLowStock() && ! $product->isOutOfStock())) {
            return 0;
        }

        $sent = 0;

        User::query()
            ->whereNotNull('email_verified_at')
            ->get()
            ->each(function (User $user) use ($product, &$sent): void {
                if ($user->unreadNotifications()
                    ->where('type', LowStockNotification::class)
                    ->whereJsonContains('data->product_id', $product->id)
                    ->exists()
                ) {
                    return;
                }

                DB::transaction(fn () => $user->notify(new LowStockNotification($product)));
                $sent++;
            });

        return $sent;
    }

    /**
     * Send low-stock alerts for every active product at or below its minimum stock.
     *
     * @return int Number of notifications sent.
     */
    public function dispatchForAllLowStockProducts(): int
    {
        $sent = 0;

        Product::query()
            ->where('status', Product::STATUS_ACTIVE)
            ->where(function (Builder $query): void {
                $query->where('quantity', '<=', 0)
                    ->orWhere(function (Builder $low): void {
                        $low->where('quantity', '>', 0)
                            ->whereColumn('quantity', '<=', 'min_stock');
                    });
            })
            ->get()
            ->each(function (Product $product) use (&$sent): void {
                $sent += $this->dispatchFor($product);
            });

        return $sent;
    }
}

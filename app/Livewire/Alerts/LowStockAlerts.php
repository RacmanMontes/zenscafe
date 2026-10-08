<?php

namespace App\Livewire\Alerts;

use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LowStockAlerts extends Component
{
    public string $panel = 'right';

    /**
     * Mark a single low-stock notification as read.
     */
    public function markAsRead(string $notificationId): void
    {
        Auth::user()->notifications()
            ->where('type', LowStockNotification::class)
            ->whereKey($notificationId)
            ->first()
            ?->markAsRead();
    }

    /**
     * Mark every low-stock notification as read.
     */
    public function markAllAsRead(): void
    {
        Auth::user()->unreadNotifications()
            ->where('type', LowStockNotification::class)
            ->update(['read_at' => now()]);
    }

    public function render()
    {
        return view('livewire.alerts.low-stock-alerts', [
            'notifications' => Auth::user()->unreadNotifications()
                ->where('type', LowStockNotification::class)
                ->latest()
                ->limit(10)
                ->get(),
            'unreadCount' => Auth::user()->unreadNotifications()
                ->where('type', LowStockNotification::class)
                ->count(),
        ]);
    }
}

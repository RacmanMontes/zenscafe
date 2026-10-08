<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Product $product,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $level = $this->product->isOutOfStock() ? 'out of stock' : 'low on stock';

        return (new MailMessage)
            ->subject('Low Stock Alert: '.$this->product->name)
            ->greeting('Low Stock Alert')
            ->line("{$this->product->name} ({$this->product->sku}) is currently {$level}.")
            ->line('Current quantity: '.$this->product->quantity.' '.$this->product->unit.' (minimum: '.$this->product->min_stock.').')
            ->action('View Product', route('products.show', $this->product))
            ->line('Please reorder this item as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'sku' => $this->product->sku,
            'unit' => $this->product->unit,
            'quantity' => $this->product->quantity,
            'min_stock' => $this->product->min_stock,
            'level' => $this->product->isOutOfStock() ? 'out_of_stock' : 'low_stock',
            'url' => route('products.show', $this->product),
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}

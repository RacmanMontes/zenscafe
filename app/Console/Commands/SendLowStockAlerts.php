<?php

namespace App\Console\Commands;

use App\Services\LowStockAlertService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('inventory:send-low-stock-alerts')]
#[Description('Send database notifications for products at or below their minimum stock level')]
class SendLowStockAlerts extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(LowStockAlertService $service): int
    {
        $sent = $service->dispatchForAllLowStockProducts();

        $this->info($sent > 0
            ? "Sent {$sent} low-stock alert(s)."
            : 'No low-stock alerts needed.');

        return self::SUCCESS;
    }
}

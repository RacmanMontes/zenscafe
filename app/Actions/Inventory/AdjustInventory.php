<?php

namespace App\Actions\Inventory;

use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Services\AuditService;
use App\Services\LowStockAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustInventory
{
    public function __construct(
        protected AuditService $auditService,
        protected LowStockAlertService $lowStockAlertService,
    ) {}

    /**
     * Adjust inventory for a product.
     */
    public function execute(
        Product $product,
        int $adjustment,
        string $reason,
        ?string $notes = null,
        ?Request $request = null,
    ): InventoryTransaction {
        return DB::transaction(function () use ($product, $adjustment, $reason, $notes, $request) {
            $lockedProduct = Product::whereKey($product->id)->lockForUpdate()->first();

            if ($lockedProduct === null) {
                throw new \DomainException('Product no longer exists.');
            }

            $previousQuantity = $lockedProduct->quantity;
            $newQuantity = $previousQuantity + $adjustment;

            if ($newQuantity < 0) {
                throw new \DomainException('Adjustment would result in negative stock. Current: '.$previousQuantity.', Adjustment: '.$adjustment);
            }

            $lockedProduct->update(['quantity' => $newQuantity]);

            $this->lowStockAlertService->dispatchFor($lockedProduct);

            $transaction = InventoryTransaction::create([
                'product_id' => $lockedProduct->id,
                'type' => TransactionType::Adjustment,
                'quantity' => abs($adjustment),
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'reason' => $reason,
                'notes' => $notes,
                'user_id' => $request?->user()?->id,
            ]);

            $this->auditService->log(
                event: 'adjustment',
                auditable: $lockedProduct,
                oldValues: ['quantity' => $previousQuantity],
                newValues: ['quantity' => $newQuantity, 'adjustment' => $adjustment, 'reason' => $reason, 'transaction_id' => $transaction->id],
                request: $request,
            );

            return $transaction;
        });
    }
}

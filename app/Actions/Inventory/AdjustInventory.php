<?php

namespace App\Actions\Inventory;

use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdjustInventory
{
    public function __construct(
        protected AuditService $auditService,
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
        $previousQuantity = $product->quantity;
        $newQuantity = $previousQuantity + $adjustment;

        if ($newQuantity < 0) {
            throw new \DomainException('Adjustment would result in negative stock. Current: '.$previousQuantity.', Adjustment: '.$adjustment);
        }

        return DB::transaction(function () use ($product, $adjustment, $reason, $notes, $previousQuantity, $newQuantity, $request) {
            $product->update(['quantity' => $newQuantity]);

            $transaction = InventoryTransaction::create([
                'product_id' => $product->id,
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
                auditable: $product,
                oldValues: ['quantity' => $previousQuantity],
                newValues: ['quantity' => $newQuantity, 'adjustment' => $adjustment, 'reason' => $reason, 'transaction_id' => $transaction->id],
                request: $request,
            );

            return $transaction;
        });
    }
}

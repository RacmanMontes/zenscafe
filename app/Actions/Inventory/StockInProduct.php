<?php

namespace App\Actions\Inventory;

use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Services\AuditService;
use App\Services\LowStockAlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StockInProduct
{
    public function __construct(
        protected AuditService $auditService,
        protected LowStockAlertService $lowStockAlertService,
    ) {}

    /**
     * Stock in a product.
     */
    public function execute(
        Product $product,
        int $quantity,
        ?int $supplierId = null,
        ?string $referenceNumber = null,
        ?string $notes = null,
        ?Carbon $transactedAt = null,
        ?Request $request = null,
    ): InventoryTransaction {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than zero.');
        }

        return DB::transaction(function () use ($product, $quantity, $supplierId, $referenceNumber, $notes, $transactedAt, $request) {
            $lockedProduct = Product::whereKey($product->id)->lockForUpdate()->first();

            if ($lockedProduct === null) {
                throw new \DomainException('Product no longer exists.');
            }

            $previousQuantity = $lockedProduct->quantity;
            $newQuantity = $previousQuantity + $quantity;

            $lockedProduct->update(['quantity' => $newQuantity]);

            $this->lowStockAlertService->dispatchFor($lockedProduct);

            $transaction = InventoryTransaction::create([
                'product_id' => $lockedProduct->id,
                'type' => TransactionType::StockIn,
                'quantity' => $quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'transacted_at' => $transactedAt ?? now(),
                'supplier_id' => $supplierId,
                'reference_number' => $referenceNumber,
                'notes' => $notes,
                'user_id' => $request?->user()?->id,
            ]);

            $this->auditService->log(
                event: 'stock_in',
                auditable: $lockedProduct,
                oldValues: ['quantity' => $previousQuantity],
                newValues: ['quantity' => $newQuantity, 'transaction_id' => $transaction->id],
                request: $request,
            );

            return $transaction;
        });
    }
}

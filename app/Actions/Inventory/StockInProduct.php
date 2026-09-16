<?php

namespace App\Actions\Inventory;

use App\Enums\TransactionType;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInProduct
{
    public function __construct(
        protected AuditService $auditService,
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
        ?Request $request = null,
    ): InventoryTransaction {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be greater than zero.');
        }

        return DB::transaction(function () use ($product, $quantity, $supplierId, $referenceNumber, $notes, $request) {
            $previousQuantity = $product->quantity;
            $newQuantity = $previousQuantity + $quantity;

            $product->update(['quantity' => $newQuantity]);

            $transaction = InventoryTransaction::create([
                'product_id' => $product->id,
                'type' => TransactionType::StockIn,
                'quantity' => $quantity,
                'previous_quantity' => $previousQuantity,
                'new_quantity' => $newQuantity,
                'supplier_id' => $supplierId,
                'reference_number' => $referenceNumber,
                'notes' => $notes,
                'user_id' => $request?->user()?->id,
            ]);

            $this->auditService->log(
                event: 'stock_in',
                auditable: $product,
                oldValues: ['quantity' => $previousQuantity],
                newValues: ['quantity' => $newQuantity, 'transaction_id' => $transaction->id],
                request: $request,
            );

            return $transaction;
        });
    }
}

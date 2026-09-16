<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\AuditService;
use Illuminate\Http\Request;

class ArchiveProduct
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Archive a product.
     */
    public function execute(Product $product, ?Request $request = null): Product
    {
        $oldValues = ['status' => $product->status];

        $product->update(['status' => Product::STATUS_ARCHIVED]);

        $this->auditService->log(
            event: 'archived',
            auditable: $product,
            oldValues: $oldValues,
            newValues: ['status' => Product::STATUS_ARCHIVED],
            request: $request,
        );

        return $product;
    }
}

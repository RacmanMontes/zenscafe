<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\AuditService;
use Illuminate\Http\Request;

class UpdateProduct
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Update an existing product.
     */
    public function execute(Product $product, array $data, ?Request $request = null): Product
    {
        $oldValues = $product->only(array_keys($data));

        $product->update($data);

        $this->auditService->log(
            event: 'updated',
            auditable: $product,
            oldValues: $oldValues,
            newValues: $product->only(array_keys($data)),
            request: $request,
        );

        return $product;
    }
}

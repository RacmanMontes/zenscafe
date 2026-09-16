<?php

namespace App\Actions\Product;

use App\Models\Product;
use App\Services\AuditService;
use Illuminate\Http\Request;

class CreateProduct
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Create a new product.
     */
    public function execute(array $data, ?Request $request = null): Product
    {
        $product = Product::create($data);

        $this->auditService->log(
            event: 'created',
            auditable: $product,
            newValues: $product->toArray(),
            request: $request,
        );

        return $product;
    }
}

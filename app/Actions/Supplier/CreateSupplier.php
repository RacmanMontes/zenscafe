<?php

namespace App\Actions\Supplier;

use App\Models\Supplier;
use App\Services\AuditService;
use Illuminate\Http\Request;

class CreateSupplier
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Create a new supplier.
     */
    public function execute(array $data, ?Request $request = null): Supplier
    {
        $supplier = Supplier::create($data);

        $this->auditService->log(
            event: 'created',
            auditable: $supplier,
            newValues: $supplier->toArray(),
            request: $request,
        );

        return $supplier;
    }
}

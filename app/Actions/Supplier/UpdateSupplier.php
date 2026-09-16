<?php

namespace App\Actions\Supplier;

use App\Models\Supplier;
use App\Services\AuditService;
use Illuminate\Http\Request;

class UpdateSupplier
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Update an existing supplier.
     */
    public function execute(Supplier $supplier, array $data, ?Request $request = null): Supplier
    {
        $oldValues = $supplier->only(array_keys($data));

        $supplier->update($data);

        $this->auditService->log(
            event: 'updated',
            auditable: $supplier,
            oldValues: $oldValues,
            newValues: $supplier->only(array_keys($data)),
            request: $request,
        );

        return $supplier;
    }
}

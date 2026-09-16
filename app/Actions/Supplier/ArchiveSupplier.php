<?php

namespace App\Actions\Supplier;

use App\Models\Supplier;
use App\Services\AuditService;
use Illuminate\Http\Request;

class ArchiveSupplier
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Archive a supplier. Throws if it has products.
     */
    public function execute(Supplier $supplier, ?Request $request = null): Supplier
    {
        if ($supplier->products()->count() > 0) {
            throw new \DomainException('Cannot archive supplier that has products. Remove or reassign products first.');
        }

        $supplier->delete();

        $this->auditService->log(
            event: 'archived',
            auditable: $supplier,
            request: $request,
        );

        return $supplier;
    }
}

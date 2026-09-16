<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Http\Request;

class ArchiveCategory
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Archive a category. Throws if it has products.
     */
    public function execute(Category $category, ?Request $request = null): Category
    {
        if ($category->products()->count() > 0) {
            throw new \DomainException('Cannot archive category that has products. Remove or reassign products first.');
        }

        $category->delete();

        $this->auditService->log(
            event: 'archived',
            auditable: $category,
            request: $request,
        );

        return $category;
    }
}

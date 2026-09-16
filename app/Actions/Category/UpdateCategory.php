<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Http\Request;

class UpdateCategory
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Update an existing category.
     */
    public function execute(Category $category, array $data, ?Request $request = null): Category
    {
        $oldValues = $category->only(array_keys($data));

        $category->update($data);

        $this->auditService->log(
            event: 'updated',
            auditable: $category,
            oldValues: $oldValues,
            newValues: $category->only(array_keys($data)),
            request: $request,
        );

        return $category;
    }
}

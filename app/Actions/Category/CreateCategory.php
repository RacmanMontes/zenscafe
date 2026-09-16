<?php

namespace App\Actions\Category;

use App\Models\Category;
use App\Services\AuditService;
use Illuminate\Http\Request;

class CreateCategory
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Create a new category.
     */
    public function execute(array $data, ?Request $request = null): Category
    {
        $category = Category::create($data);

        $this->auditService->log(
            event: 'created',
            auditable: $category,
            newValues: $category->toArray(),
            request: $request,
        );

        return $category;
    }
}

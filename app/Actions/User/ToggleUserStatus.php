<?php

namespace App\Actions\User;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;

class ToggleUserStatus
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Toggle a user's active status by setting email_verified_at.
     */
    public function execute(User $user, ?Request $request = null): User
    {
        $oldValues = ['status' => $user->email_verified_at ? 'active' : 'inactive'];

        $user->email_verified_at = $user->email_verified_at ? null : now();
        $user->save();

        $newStatus = $user->fresh()->email_verified_at ? 'active' : 'inactive';

        $this->auditService->log(
            event: 'status_changed',
            auditable: $user,
            oldValues: $oldValues,
            newValues: ['status' => $newStatus],
            request: $request,
        );

        return $user;
    }
}

<?php

namespace App\Actions\User;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdateUser
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Update a user.
     */
    public function execute(User $user, array $data, ?Request $request = null): User
    {
        $oldValues = $user->only(['name', 'email', 'role']);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $actingUser = $request?->user() ?? auth()->user();

        if (isset($data['role']) && $actingUser?->isAdmin()) {
            $user->role = UserRole::from($data['role']);
        }
        unset($data['role']);

        $user->update($data);

        if ($user->wasChanged('role') || $user->wasChanged('name') || $user->wasChanged('email')) {
            $this->auditService->log(
                event: 'updated',
                auditable: $user,
                oldValues: $oldValues,
                newValues: $user->only(['name', 'email', 'role']),
                request: $request,
            );
        }

        return $user;
    }
}

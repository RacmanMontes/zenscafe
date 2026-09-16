<?php

namespace App\Actions\User;

use App\Enums\UserRole;
use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CreateUser
{
    public function __construct(
        protected AuditService $auditService,
    ) {}

    /**
     * Create a new user.
     */
    public function execute(array $data, ?Request $request = null): User
    {
        $actingUser = $request?->user() ?? auth()->user();
        $role = ($actingUser?->isAdmin() ? ($data['role'] ?? 'staff') : 'staff');
        unset($data['role']);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $user->role = UserRole::from($role);
        $user->save();

        $this->auditService->log(
            event: 'created',
            auditable: $user,
            newValues: $user->only(['name', 'email', 'role']),
            request: $request,
        );

        return $user;
    }
}

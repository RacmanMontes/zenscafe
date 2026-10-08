<?php

namespace App\Policies;

use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    /**
     * Determine whether the user can view any suppliers.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can create suppliers.
     */
    public function create(User $user): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can update the supplier.
     */
    public function update(User $user, Supplier $supplier): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can archive the supplier.
     */
    public function delete(User $user, Supplier $supplier): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Any user with an assigned role may manage suppliers.
     */
    private function isAuthorized(User $user): bool
    {
        return $user->role !== null;
    }
}

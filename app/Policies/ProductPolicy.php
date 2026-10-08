<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determine whether the user can view any products.
     */
    public function viewAny(User $user): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can view the product.
     */
    public function view(User $user, Product $product): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can create products.
     */
    public function create(User $user): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can update the product.
     */
    public function update(User $user, Product $product): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Determine whether the user can archive the product.
     */
    public function delete(User $user, Product $product): bool
    {
        return $this->isAuthorized($user);
    }

    /**
     * Any user with an assigned role may manage products.
     */
    private function isAuthorized(User $user): bool
    {
        return $user->role !== null;
    }
}

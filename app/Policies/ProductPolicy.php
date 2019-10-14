<?php

namespace App\Policies;

use App\User;
use App\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function addCategory(User $user, Product $product)
    {
        $user->id ===$product->seller->id;
    }

    /**
     * Determine whether the user can delete the policy.
     *
     * @param  \App\User  $user
     * @param  \App\Product  $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
    {
        $user->id === $product->seller->id;
    }
}

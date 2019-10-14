<?php

namespace App\Policies;

use App\User;
use App\Seller;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any sellers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function view(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the user can create sellers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function update(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can delete the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function delete(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can restore the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function restore(User $user, Seller $seller)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the seller.
     *
     * @param  \App\User  $user
     * @param  \App\Seller  $seller
     * @return mixed
     */
    public function forceDelete(User $user, Seller $seller)
    {
        //
    }

    public function editProduct(User $user, Seller $seller) 
    {
        return $user->id === $seller->id;
    }

    public function deleteProduct(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }

    public function sale(User $user, Seller $seller)
    {
        return $user->id === $seller->id;
    }
}

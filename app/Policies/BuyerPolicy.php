<?php

namespace App\Policies;

use App\User;
use App\Buyer;
use App\Traits\AdminActions;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyerPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can view any buyers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
    }

    /**
     * Determine whether the user can view the buyer.
     *
     * @param  \App\User  $user
     * @param  \App\buyer  $buyer
     * @return mixed
     */
    public function view(User $user, Buyer $buyer)
    {
        return $user->id === $buyer->id;
    }

    /**
     * Determine whether the user can create buyers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the buyer.
     *
     * @param  \App\User  $user
     * @param  \App\buyer  $buyer
     * @return mixed
     */
    public function update(User $user, Buyer $buyer)
    {
        //
    }

    /**
     * Determine whether the user can delete the buyer.
     *
     * @param  \App\User  $user
     * @param  \App\buyer  $buyer
     * @return mixed
     */
    public function delete(User $user, Buyer $buyer)
    {
        //
    }

    /**
     * Determine whether the user can restore the buyer.
     *
     * @param  \App\User  $user
     * @param  \App\buyer  $buyer
     * @return mixed
     */
    public function restore(User $user, Buyer $buyer)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the buyer.
     *
     * @param  \App\User  $user
     * @param  \App\buyer  $buyer
     * @return mixed
     */
    public function forceDelete(User $user, Buyer $buyer)
    {
        //
    }

    public function purchase(User $user, Buyer $buyer)
    {
        return $user->id === $buyer->id;
    }
}

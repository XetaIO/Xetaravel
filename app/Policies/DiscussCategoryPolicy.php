<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussCategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all discuss categories.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('viewAny discuss category');
    }

    /**
     * Determine whether the user can create a discuss category.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create discuss category');
    }

    /**
     * Determine whether the user can update a discuss category.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update discuss category');
    }

    /**
     * Determine whether the user can delete a discuss category.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete discuss category');
    }
}

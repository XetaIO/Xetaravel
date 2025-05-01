<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all roles.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('viewAny role');
    }

    /**
     * Determine whether the user can create a role.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create role');
    }

    /**
     * Determine whether the user can update a role.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update role');
    }

    /**
     * Determine whether the user can delete a role.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete role');
    }

    /**
     * Determine whether the user can search a role.
     *
     * @param User $user
     *
     * @return bool
     */
    public function search(User $user): bool
    {
        return $user->hasPermissionTo('search role');
    }
}

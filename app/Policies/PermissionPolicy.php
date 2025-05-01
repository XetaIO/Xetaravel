<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all permissions.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('viewAny permission');
    }

    /**
     * Determine whether the user can create a permission.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create permission');
    }

    /**
     * Determine whether the user can update a permission.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update permission');
    }

    /**
     * Determine whether the user can delete a permission.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete permission');
    }

    /**
     * Determine whether the user can search a permission.
     *
     * @param User $user
     *
     * @return bool
     */
    public function search(User $user): bool
    {
        return $user->hasPermissionTo('search permission');
    }
}

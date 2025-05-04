<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BadgePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all badges.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('viewAny badge');
    }

    /**
     * Determine whether the user can create a badge.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create badge');
    }

    /**
     * Determine whether the user can update a badge.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update badge');
    }

    /**
     * Determine whether the user can delete a badge.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete badge');
    }

    /**
     * Determine whether the user can search a badge.
     *
     * @param User $user
     *
     * @return bool
     */
    public function search(User $user): bool
    {
        return $user->hasPermissionTo('search badge');
    }
}

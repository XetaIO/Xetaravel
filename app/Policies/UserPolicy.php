<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update a user.
     *
     * @param User $user
     * @param User|null $model
     *
     * @return bool
     */
    public function update(User $user, ?User $model = null): bool
    {
        // First check if user can update any user and a user has been provided
        if ($user->hasPermissionTo('update user') && !is_null($model)) {
            // Check if the user level is superior or equal to the other user level he wants to edit.
            return $user->level >= $model->level;
        }

        return $user->hasPermissionTo('update user');
    }

    /**
     * Determine whether the user can delete a user.
     *
     * @param User $user
     * @param User|null $model
     *
     * @return bool
     */
    public function delete(User $user, ?User $model = null): bool
    {
        // First check if user can delete any user and a user has been provided
        if ($user->hasPermissionTo('delete user') && !is_null($model)) {
            // Check if the user level is superior or equal to the other user level he wants to edit.
            return $user->level >= $model->level;
        }
        return $user->hasPermissionTo('delete user');
    }

    /**
     * Determine whether the user can delete a user.
     *
     * @param User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->hasPermissionTo('restore user');
    }

    /**
     * Determine whether the user can search in the model.
     *
     * @param User $user
     *
     * @return bool
     */
    public function search(User $user): bool
    {
        return $user->hasPermissionTo('search user');
    }

    /**
     * Determine whether the user can assign direct permission the model.
     *
     * @param User $user
     *
     * @return bool
     */
    public function assignDirectPermission(User $user): bool
    {
        return $user->hasPermissionTo('assign-direct-permission user');
    }
}

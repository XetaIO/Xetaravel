<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view all settings.
     *
     * @param User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('viewAny setting');
    }

    /**
     * Determine whether the user can create a setting.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create setting');
    }

    /**
     * Determine whether the user can update a setting.
     *
     * @param User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->hasPermissionTo('update setting');
    }

    /**
     * Determine whether the user can delete a setting.
     *
     * @param User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasPermissionTo('delete setting');
    }
}

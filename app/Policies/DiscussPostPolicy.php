<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\DiscussPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussPostPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize all actions if the user has the given permission.
     *
     * @param User $user
     * @param string $ability
     *
     * @return true|void
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasPermissionTo('manage discuss post')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create a discuss post.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create discuss post');
    }

    /**
     * Determine whether the user can update the discuss post.
     *
     * @param User $user
     * @param DiscussPost $discussPost
     *
     * @return bool
     */
    public function update(User $user, DiscussPost $discussPost): bool
    {
        return $user->id === $discussPost->user_id && $user->hasPermissionTo('update discuss post');
    }

    /**
     * Determine whether the user can delete the discuss post.
     *
     * @param User $user
     * @param DiscussPost $discussPost
     *
     * @return bool
     */
    public function delete(User $user, DiscussPost $discussPost): bool
    {
        return $user->id === $discussPost->user_id && $user->hasPermissionTo('delete discuss post');
    }
}

<?php
namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\DiscussThread;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Authorize all actions if the user has the given permission.
     *
     * @param \Xetaravel\Models\User $user
     * @param string $ability
     *
     * @return true|void
     */
    public function before(User $user, string $ability)
    {
        if ($user->hasPermission('manage.discuss.threads')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the discussThread.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussThread $discussThread
     *
     * @return bool
     */
    public function update(User $user, DiscussThread $discussThread)
    {
        return $user->id === $discussThread->user_id;
    }

    /**
     * Determine whether the user can delete the discussThread.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussThread $discussThread
     *
     * @return bool
     */
    public function delete(User $user, DiscussThread $discussThread)
    {
        return $user->id === $discussThread->user_id;
    }
}

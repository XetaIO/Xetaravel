<?php
namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\DiscussComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussCommentPolicy
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
        if ($user->hasPermission('manage.discuss.comments')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the discussComment.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussComment $discussComment
     *
     * @return bool
     */
    public function update(User $user, DiscussComment $discussComment)
    {
        return $user->id === $discussComment->user_id;
    }

    /**
     * Determine whether the user can delete the discussComment.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\DiscussComment $discussComment
     *
     * @return bool
     */
    public function delete(User $user, DiscussComment $discussComment)
    {
        return $user->id === $discussComment->user_id;
    }
}

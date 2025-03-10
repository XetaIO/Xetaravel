<?php

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCommentPolicy
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
        if ($user->hasPermission('manage.blog.comments')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the discuss post.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\Comment $comment
     *
     * @return bool
     */
    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the discuss post.
     *
     * @param \Xetaravel\Models\User $user
     * @param \Xetaravel\Models\Comment $comment
     *
     * @return bool
     */
    public function delete(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}

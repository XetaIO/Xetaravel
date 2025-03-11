<?php

namespace Xetaravel\Policies;

use Xetaravel\Models\User;
use Xetaravel\Models\BlogComment;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogCommentPolicy
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
        if ($user->hasPermission('manage.blog.comments')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the discuss post.
     *
     * @param User $user
     * @param \Xetaravel\Models\BlogComment $comment
     *
     * @return bool
     */
    public function update(User $user, BlogComment $comment)
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Determine whether the user can delete the discuss post.
     *
     * @param User $user
     * @param \Xetaravel\Models\BlogComment $comment
     *
     * @return bool
     */
    public function delete(User $user, BlogComment $comment)
    {
        return $user->id === $comment->user_id;
    }
}

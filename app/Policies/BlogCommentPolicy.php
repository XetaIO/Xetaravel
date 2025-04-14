<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\BlogArticle;
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
        if ($user->hasPermissionTo('manage blog comment')) {
            return true;
        }
    }

    /**
     * Determine whether the user can create a blog comment.
     *
     * @param User $user
     * @param BlogArticle $article
     * @return bool
     */
    public function create(User $user, BlogArticle $article): bool
    {
        return $article->published_at <= now() &&
            $user->hasPermissionTo('create blog comment');
    }

    /**
     * Determine whether the user can update a blog comment.
     *
     * @param User $user
     * @param BlogComment $comment
     *
     * @return bool
     */
    public function update(User $user, BlogComment $comment): bool
    {
        return $user->id === $comment->user_id &&
            $user->hasPermissionTo('update blog comment');
    }

    /**
     * Determine whether the user can delete a blog comment.
     *
     * @param User $user
     * @param BlogComment $comment
     * @param BlogArticle $article
     *
     * @return bool
     */
    public function delete(User $user, BlogComment $comment, BlogArticle $article): bool
    {
        return $user->id === $comment->user_id &&
            $article->id === $comment->blog_article_id &&
            $user->hasPermissionTo('delete blog comment');
    }
}

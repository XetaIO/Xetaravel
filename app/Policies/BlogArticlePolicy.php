<?php

declare(strict_types=1);

namespace Xetaravel\Policies;

use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create a blog article.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create blog article');
    }

    /**
     * Determine whether the user can update a blog article.
     *
     * @param User $user
     * @param BlogArticle $blogArticle
     *
     * @return bool
     */
    public function update(User $user, BlogArticle $blogArticle): bool
    {
        return $user->id === $blogArticle->user_id && $user->hasPermissionTo('update blog article') || $user->hasPermissionTo('manage blog article');
    }

    /**
     * Determine whether the user can delete a blog article.
     *
     * @param User $user
     * @param BlogArticle $blogArticle
     *
     * @return bool
     */
    public function delete(User $user, BlogArticle $blogArticle): bool
    {
        return $user->id === $blogArticle->user_id && $user->hasPermissionTo('delete blog article') || $user->hasPermissionTo('manage blog article');
    }
}

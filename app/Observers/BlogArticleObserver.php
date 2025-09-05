<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Xetaravel\Models\BlogArticle;

class BlogArticleObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(BlogArticle $blogArticle): void
    {
        $blogArticle->user_id = Auth::id();
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(BlogArticle $blogArticle): void
    {
        if ($blogArticle->isDirty('title')) {
            $blogArticle->generateSlug();
        }
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(BlogArticle $blogArticle): void
    {
        DB::transaction(function () use ($blogArticle) {
            // We need to do this to refresh the countable cache `blog_comment_count` of the user.
            $blogArticle->loadMissing('comments');
            foreach ($blogArticle->comments as $comment) {
                $comment->delete();
            }
        });
    }
}

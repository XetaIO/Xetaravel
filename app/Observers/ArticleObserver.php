<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\BlogArticle;

class ArticleObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(BlogArticle $article): void
    {
        if (is_null($article->user_id)) {
            $article->user_id = Auth::id();
        }
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(BlogArticle $article): void
    {
        $article->generateSlug();
    }
}

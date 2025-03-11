<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Article;

class ArticleObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(Article $article): void
    {
        if (is_null($article->user_id)) {
            $article->user_id = Auth::id();
        }
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(Article $article): void
    {
        $article->generateSlug();
    }
}

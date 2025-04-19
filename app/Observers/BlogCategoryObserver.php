<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Xetaravel\Models\BlogCategory;

class BlogCategoryObserver
{

    /**
     * Handle the "deleting" event.
     */
    public function deleting(BlogCategory $blogCategory): void
    {
        // We need to do this to refresh the countable cache `blog_comment_count` of the user.
        $blogCategory->loadMissing('articles');
        foreach ($blogCategory->articles as $article) {
            $article->delete();
        }
    }
}

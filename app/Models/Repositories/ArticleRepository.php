<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\BlogArticle;

class ArticleRepository
{
    /**
     * Find the latest articles for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sidebar(): Collection
    {
        return BlogArticle::with('category', 'user')
            ->latest()
            ->take(config('xetaravel.blog.articles_sidebar'))
            ->get();
    }
}

<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\Article;

class ArticleRepository
{
    /**
     * Find the latest articles for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sidebar(): Collection
    {
        return Article::latest()->take(5)->get();
    }
}

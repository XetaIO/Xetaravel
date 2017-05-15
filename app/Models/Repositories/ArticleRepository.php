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

    /**
     * Create the new article and save it.
     *
     * @param array $data The data used to create the article.
     *
     * @return bool
     */
    public static function create(array $data): bool
    {
        $article = new Article;
        $article->title = $data['title'];
        $article->category_id = $data['category_id'];
        $article->is_display = isset($data['is_display']) ? true : false;
        $article->content = $data['content'];

        return $article->save();
    }

    /**
     * Update the article data and save it.
     *
     * @param array $data The data used to update the article.
     *
     * @return bool
     */
    public static function update(array $data, Article $article): bool
    {
        $article->title = $data['title'];
        $article->category_id = $data['category_id'];
        $article->is_display = isset($data['is_display']) ? true : false;
        $article->content = $data['content'];

        return $article->save();
    }
}

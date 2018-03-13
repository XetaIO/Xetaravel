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
        return Article::latest()->take(config('xetaravel.blog.articles_sidebar'))->get();
    }

    /**
     * Create the new article and save it.
     *
     * @param array $data The data used to create the article.
     *
     * @return \Xetaravel\Models\Article
     */
    public static function create(array $data): Article
    {
        return Article::create([
            'title' => $data['title'],
            'category_id' => $data['category_id'],
            'is_display' => isset($data['is_display']) ? true : false,
            'content' => $data['content']
        ]);
    }

    /**
     * Update the article data and save it.
     *
     * @param array $data The data used to update the article.
     * @param \Xetaravel\Models\Article $article The article to update.
     *
     * @return \Xetaravel\Models\Article
     */
    public static function update(array $data, Article $article): Article
    {
        $article->title = $data['title'];
        $article->category_id = $data['category_id'];
        $article->is_display = isset($data['is_display']) ? true : false;
        $article->content = $data['content'];
        $article->save();

        return $article;
    }
}

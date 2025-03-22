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
        return BlogArticle::latest()->take(config('xetaravel.blog.articles_sidebar'))->get();
    }

    /**
     * Create the new article and save it.
     *
     * @param array $data The data used to create the article.
     *
     * @return BlogArticle
     */
    public static function create(array $data): BlogArticle
    {
        return BlogArticle::create([
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
     * @param BlogArticle $article The article to update.
     *
     * @return BlogArticle
     */
    public static function update(array $data, BlogArticle $article): BlogArticle
    {
        $article->title = $data['title'];
        $article->category_id = $data['category_id'];
        $article->is_display = isset($data['is_display']) ? true : false;
        $article->content = $data['content'];
        $article->save();

        return $article;
    }
}

<?php
namespace Xetaravel\Models\Presenters;

trait ArticlePresenter
{
    /**
     * Get the article url.
     *
     * @return string
     */
    public function getArticleUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        return route('blog.article.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }
}

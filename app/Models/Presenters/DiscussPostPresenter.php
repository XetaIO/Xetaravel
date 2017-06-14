<?php
namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;

trait DiscussPostPresenter
{
    /**
     * Get the content parsed in HTML.
     *
     * @return string
     */
    public function getContentMarkdownAttribute(): string
    {
        return Markdown::convertToHtml($this->content);
    }

    /**
     * Get the post url.
     *
     * @return string
     */
    public function getPostUrlAttribute(): string
    {
        return route('discuss.post.show', ['id' => $this->getKey()]);
    }
}

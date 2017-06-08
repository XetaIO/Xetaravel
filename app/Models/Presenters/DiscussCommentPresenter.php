<?php
namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;

trait DiscussCommentPresenter
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
     * Get the comment url.
     *
     * @return string
     */
    public function getCommentUrlAttribute(): string
    {
        return route('discuss.comment.show', ['id' => $this->getKey()]);
    }
}

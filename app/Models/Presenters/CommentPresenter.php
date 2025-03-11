<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;

trait CommentPresenter
{
    /**
     * Get the content parsed in HTML.
     *
     * @return string
     */
    public function getContentMarkdownAttribute(): string
    {
        return Markdown::convert($this->content);
    }

    /**
     * Get the comment url.
     *
     * @return string
     */
    public function getCommentUrlAttribute(): string
    {
        return route('blog.comment.show', ['id' => $this->getKey()]);
    }
}

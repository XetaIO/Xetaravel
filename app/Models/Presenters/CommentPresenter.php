<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Output\RenderedContentInterface;

trait CommentPresenter
{
    /**
     * Get the content parsed in HTML.
     *
     * @return RenderedContentInterface
     *
     * @throws CommonMarkException
     */
    public function getContentMarkdownAttribute(): RenderedContentInterface
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

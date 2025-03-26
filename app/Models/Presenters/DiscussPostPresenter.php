<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;
use League\CommonMark\Exception\CommonMarkException;
use League\CommonMark\Output\RenderedContentInterface;

trait DiscussPostPresenter
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
     * Get the post url.
     *
     * @return string
     */
    public function getPostUrlAttribute(): string
    {
        return route('discuss.post.show', ['id' => $this->getKey()]);
    }
}

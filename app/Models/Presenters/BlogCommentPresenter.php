<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait BlogCommentPresenter
{
    /**
     * Get the content parsed in HTML.
     *
     * @return Attribute
     *
     */
    protected function contentMarkdown(): Attribute
    {
        return Attribute::make(
            get: fn () => Markdown::convert($this->content)
        );
    }

    /**
     * Get the comment url.
     *
     * @return Attribute
     */
    protected function commentUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('blog.comment.show', ['id' => $this->getKey()])
        );
    }
}

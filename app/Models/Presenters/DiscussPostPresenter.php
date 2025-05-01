<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait DiscussPostPresenter
{
    /**
     * Get the content parsed in HTML.
     *
     * @return Attribute
     */
    protected function contentMarkdown(): Attribute
    {
        return Attribute::make(
            get: fn () => Markdown::convert($this->content)
        );
    }

    /**
     * Get the post url.
     *
     * @return Attribute
     */
    protected function postUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('discuss.post.show', ['id' => $this->getKey()])
        );
    }
}

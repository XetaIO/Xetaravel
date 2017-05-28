<?php
namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;

trait CommentPresenter
{
    /**
     * Get the account first name.
     *
     * @return string
     */
    public function getContentMarkdownAttribute(): string
    {
        return Markdown::convertToHtml($this->content);
    }
}

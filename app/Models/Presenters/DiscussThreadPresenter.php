<?php
namespace Xetaravel\Models\Presenters;

use GrahamCampbell\Markdown\Facades\Markdown;

trait DiscussThreadPresenter
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
     * Get the thread url.
     *
     * @return string
     */
    public function getThreadUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        return route('discuss.thread.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }

    /**
     * Get the last page number for the thread.
     *
     * @return int
     */
    public function getLastPageAttribute(): int
    {
        $comments = $this->comment_count;

        if ($this->is_solved) {
            $comments = $this->comment_count - 1;
        }
        $page = ceil($comments / config('xetaravel.pagination.discuss.comment_per_page'));

        return ($page) ? $page : 1;
    }
}

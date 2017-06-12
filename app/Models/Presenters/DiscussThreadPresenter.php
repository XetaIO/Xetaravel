<?php
namespace Xetaravel\Models\Presenters;

trait DiscussThreadPresenter
{
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
        $page = ceil($this->comment_count / config('xetaravel.pagination.discuss.comment_per_page'));

        if ($this->is_solved) {
            $page--;
        }

        return ($page) ? $page : 1;
    }
}

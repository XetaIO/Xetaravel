<?php
namespace Xetaravel\Models\Presenters;

trait DiscussConversationPresenter
{
    /**
     * We must decrement the post count due to the first post being counted.
     *
     * @param int $count The actual post count cache.
     *
     * @return int
     */
    public function getPostCountFormatedAttribute(): int
    {
        return $this->post_count - 1;
    }

    /**
     * Get the conversation url.
     *
     * @return string
     */
    public function getConversationUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        return route('discuss.conversation.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }

    /**
     * Get the last page number for the conversation.
     *
     * @return int
     */
    public function getLastPageAttribute(): int
    {
        $posts = $this->post_count_formated;

        if ($this->is_solved) {
            $posts = $posts - 1;
        }

        $page = ceil($posts / config('xetaravel.pagination.discuss.post_per_page'));

        return ($page) ? $page : 1;
    }
}

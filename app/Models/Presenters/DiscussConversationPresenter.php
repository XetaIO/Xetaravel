<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait DiscussConversationPresenter
{
    /**
     * We must decrement the post count due to the first post being counted.
     *
     * @return Attribute
     */
    protected function postCountFormated(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->post_count - 1
        );
    }

    /**
     * Get the conversation url.
     *
     * @return Attribute
     */
    protected function conversationUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('discuss.conversation.show', ['slug' => $this->slug, 'id' => $this->getKey()])
        );
    }

    /**
     * Get the last page number for the conversation.
     *
     * @return Attribute
     */
    protected function lastPage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $posts = $this->post_count_formated;

                if ($this->is_solved) {
                    $posts = $posts - 1;
                }

                $page = (int) ceil($posts / config('xetaravel.pagination.discuss.post_per_page'));

                return $page ?: 1;
            }
        );
    }
}

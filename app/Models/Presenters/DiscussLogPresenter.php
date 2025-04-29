<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\User;

trait DiscussLogPresenter
{
    /**
     * Get the type related to the Event.
     *
     * @return Attribute
     */
    protected function type(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->event_type) {
                CategoryWasChangedEvent::class => 'category',
                TitleWasChangedEvent::class => 'title',
                ConversationWasLockedEvent::class => 'locked',
                ConversationWasPinnedEvent::class => 'pinned',
                PostWasDeletedEvent::class => 'deleted',
                default => 'unknown',
            }
        );
    }

    /**
     * Get the user related to the deleted post.
     *
     * @return Attribute
     */
    protected function postUser(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->event_type !== PostWasDeletedEvent::class ? null : User::find($this->data['post_user_id'])
        );
    }

    /**
     * Get the old category.
     *
     * @return Attribute
     */
    protected function oldCategory(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->event_type !== CategoryWasChangedEvent::class ? null : DiscussCategory::find($this->data['old'])
        );
    }

    /**
     * Get the new category.
     *
     * @return Attribute
     */
    protected function newCategory(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->event_type !== CategoryWasChangedEvent::class ? null : DiscussCategory::find($this->data['new'])
        );
    }
}

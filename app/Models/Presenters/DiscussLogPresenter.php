<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

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
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return match ($this->event_type) {
            CategoryWasChangedEvent::class => 'category',
            TitleWasChangedEvent::class => 'title',
            ConversationWasLockedEvent::class => 'locked',
            ConversationWasPinnedEvent::class => 'pinned',
            PostWasDeletedEvent::class => 'deleted',
            default => 'unknown',
        };
    }

    /**
     * Get the user related to the deleted post.
     *
     * @return null|User
     */
    public function getPostUserAttribute(): ?User
    {
        if ($this->event_type !== PostWasDeletedEvent::class) {
            return null;
        }

        return User::find($this->data['post_user_id']);
    }

    /**
     * Get the old category.
     *
     * @return null|DiscussCategory
     */
    public function getOldCategoryAttribute(): ?DiscussCategory
    {
        if ($this->event_type !== CategoryWasChangedEvent::class) {
            return null;
        }

        return DiscussCategory::find($this->data['old']);
    }

    /**
     * Get the new category.
     *
     * @return null|DiscussCategory
     */
    public function getNewCategoryAttribute(): ?DiscussCategory
    {
        if ($this->event_type !== CategoryWasChangedEvent::class) {
            return null;
        }

        return DiscussCategory::find($this->data['new']);
    }
}

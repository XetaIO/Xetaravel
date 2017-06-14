<?php
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
    public function getTypeAttribute()
    {
        switch ($this->event_type) {
            case CategoryWasChangedEvent::class:
                return 'category';
                break;
            case TitleWasChangedEvent::class:
                return 'title';
                break;
            case ConversationWasLockedEvent::class:
                return 'locked';
                break;
            case ConversationWasPinnedEvent::class:
                return 'pinned';
                break;
            case PostWasDeletedEvent::class:
                return 'deleted';
                break;
            default:
                return 'unknown';
        }
    }

    /**
     * Get the user related to the deleted post.
     *
     * @return null|\Xetaravel\Models\User
     */
    public function getPostUserAttribute()
    {
        if ($this->event_type !== PostWasDeletedEvent::class) {
            return null;
        }

        return User::find($this->data['post_user_id']);
    }

    /**
     * Get the old category.
     *
     * @return null|\Xetaravel\Models\DiscussCategory
     */
    public function getOldCategoryAttribute()
    {
        if ($this->event_type !== CategoryWasChangedEvent::class) {
            return null;
        }

        return DiscussCategory::find($this->data['old']);
    }

    /**
     * Get the new category.
     *
     * @return null|\Xetaravel\Models\DiscussCategory
     */
    public function getNewCategoryAttribute()
    {
        if ($this->event_type !== CategoryWasChangedEvent::class) {
            return null;
        }

        return DiscussCategory::find($this->data['new']);
    }
}

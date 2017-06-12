<?php
namespace Xetaravel\Models\Presenters;

use Xetaravel\Events\Discuss\CommentWasDeletedEvent;
use Xetaravel\Events\Discuss\ThreadTitleWasChangedEvent;
use Xetaravel\Events\Discuss\ThreadCategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ThreadWasLockedEvent;
use Xetaravel\Events\Discuss\ThreadWasPinnedEvent;
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
            case ThreadCategoryWasChangedEvent::class:
                return 'category';
                break;
            case ThreadTitleWasChangedEvent::class:
                return 'title';
                break;
            case ThreadWasLockedEvent::class:
                return 'locked';
                break;
            case ThreadWasPinnedEvent::class:
                return 'pinned';
                break;
            case CommentWasDeletedEvent::class:
                return 'deleted';
                break;
            default:
                return 'unknown';
        }
    }

    /**
     * Get the user related to the deleted comment.
     *
     * @return null|\Xetaravel\Models\DiscussCategory
     */
    public function getCommentUserAttribute()
    {
        if ($this->event_type !== CommentWasDeletedEvent::class) {
            return null;
        }

        return User::find($this->data['comment_user_id']);
    }

    /**
     * Get the old category.
     *
     * @return null|\Xetaravel\Models\DiscussCategory
     */
    public function getOldCategoryAttribute()
    {
        if ($this->event_type !== ThreadCategoryWasChangedEvent::class) {
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
        if ($this->event_type !== ThreadCategoryWasChangedEvent::class) {
            return null;
        }

        return DiscussCategory::find($this->data['new']);
    }
}

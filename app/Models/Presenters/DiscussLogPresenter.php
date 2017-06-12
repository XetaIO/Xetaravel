<?php
namespace Xetaravel\Models\Presenters;

use Xetaravel\Events\Discuss\ThreadTitleWasChangedEvent;
use Xetaravel\Events\Discuss\ThreadCategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ThreadWasLockedEvent;
use Xetaravel\Events\Discuss\ThreadWasPinnedEvent;
use Xetaravel\Models\DiscussCategory;

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
            default:
                return 'unknown';
        }
    }

    /**
     * Get the old category.
     *
     * @return \Xetaravel\Models\DiscussCategory
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
     * @return \Xetaravel\Models\DiscussCategory
     */
    public function getNewCategoryAttribute()
    {
        if ($this->event_type !== ThreadCategoryWasChangedEvent::class) {
            return null;
        }

        return DiscussCategory::find($this->data['new']);
    }
}

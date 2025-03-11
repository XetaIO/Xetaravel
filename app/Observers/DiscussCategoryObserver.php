<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Xetaravel\Models\DiscussCategory;

class DiscussCategoryObserver
{
    /**
     * Handle the "deleting" event.
     */
    public function deleting(DiscussCategory $discussCategory): void
    {
        $discussCategory->last_conversation_id = null;
        $discussCategory->save();

        foreach ($discussCategory->conversations as $conversation) {
            $conversation->delete();
        }
    }
}

<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\DB;
use Xetaravel\Models\DiscussCategory;

class DiscussCategoryObserver
{
    /**
     * Handle the "deleting" event.
     */
    public function deleting(DiscussCategory $discussCategory): void
    {
        DB::transaction(function () use ($discussCategory) {
            $discussCategory->last_conversation_id = null;
            $discussCategory->save();

            foreach ($discussCategory->conversations as $conversation) {
                $conversation->delete();
            }
        });
    }
}

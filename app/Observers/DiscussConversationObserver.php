<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\Repositories\DiscussConversationRepository;

class DiscussConversationObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(DiscussConversation $discussConversation): void
    {
        if (is_null($discussConversation->user_id)) {
            $discussConversation->user_id = Auth::id();
        }
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(DiscussConversation $discussConversation): void
    {
        $discussConversation->generateSlug();
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(DiscussConversation $discussConversation): void
    {
        $category = $discussConversation->category;

        // If the conversation is the last_conversation of the category,
        // find the new last_conversation and update the category.
        if ($category->last_conversation_id == $discussConversation->getKey()) {
            $previousConversation = DiscussConversationRepository::findPreviousConversation($discussConversation);

            if (is_null($previousConversation)) {
                $category->last_conversation_id = null;
            } else {
                $category->last_conversation_id = $previousConversation->getKey();
            }

            $category->save();
        }

        // Set the foreign keys to null, else it won't delete since it delete
        // the posts before the conversation.
        $discussConversation->first_post_id = null;
        $discussConversation->last_post_id = null;
        $discussConversation->solved_post_id = null;
        $discussConversation->save();

        // We need to do this to refresh the countable cache `discuss_post_count` of the user.
        foreach ($discussConversation->posts as $post) {
            $post->delete();
        }

        // It don't delete the logs, so we need to do it manually.
        foreach ($discussConversation->discussLogs as $log) {
            $log->delete();
        }
    }
}

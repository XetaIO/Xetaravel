<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Xetaravel\Models\DiscussConversation;

class DiscussConversationRepository
{
    /**
     * Find the previous conversation related to the given conversation.
     *
     * @param DiscussConversation $conversation
     *
     * @return DiscussConversation|null
     */
    public static function findPreviousConversation(DiscussConversation $conversation): ?DiscussConversation
    {
        return DiscussConversation::where('category_id', $conversation->category->getKey())
            ->where('created_at', '<', $conversation->created_at)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}

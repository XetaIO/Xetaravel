<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussConversation;

class DiscussPostRepository
{
    /**
     * Find the previous post related to the given post.
     *
     * @param DiscussPost $post
     * @param bool $withSolved
     *
     * @return DiscussPost|null
     */
    public static function findPreviousPost(DiscussPost $post, bool $withSolved = false): ?DiscussPost
    {
        $previousPost = DiscussPost::where('id', '!=', $post->getKey())
                ->where('conversation_id', $post->conversation->getKey())
                ->where('created_at', '<=', $post->created_at);

        if (!$withSolved) {
            $previousPost = $previousPost->where('id', '!=', $post->conversation->solved_post_id);
        }

        return $previousPost->orderBy('created_at', 'desc')
                ->first();
    }
}

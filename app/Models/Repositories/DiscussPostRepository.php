<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussConversation;

class DiscussPostRepository
{
    /**
     * Create a new post instance after a valid validation.
     *
     * @param array $data The data used to create the post.
     *
     * @return \Xetaravel\Models\DiscussPost
     */
    public static function create(array $data): DiscussPost
    {
        $post = DiscussPost::create([
            'conversation_id' => $data['conversation_id'],
            'content' => $data['content']
        ]);

        $conversation = DiscussConversation::find($data['conversation_id']);

        if (Auth::user()->hasPermission('manage.discuss.conversations')) {
            $data['is_pinned'] = isset($data['is_pinned']) ? true : false;
            $data['is_locked'] = isset($data['is_locked']) ? true : false;

            if ($conversation->is_pinned != $data['is_pinned'] && $data['is_pinned'] == true) {
                event(new ConversationWasPinnedEvent($conversation));
            }

            if ($conversation->is_locked != $data['is_locked'] && $data['is_locked'] == true) {
                event(new ConversationWasLockedEvent($conversation));
            }

            $conversation->is_locked = $data['is_locked'];
            $conversation->is_pinned = $data['is_pinned'];
        }

        $conversation->last_post_id = $post->getKey();

        $conversation->save();

        return $post;
    }

    /**
     * Find the previous post related to the given post.
     *
     * @param \Xetaravel\Models\DiscussPost $post
     *
     * @return \Xetaravel\Models\DiscussPost|null
     */
    public static function findPreviousPost(DiscussPost $post, bool $withSolved = false)
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

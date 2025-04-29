<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\Repositories\DiscussPostRepository;

class DiscussPostObserver
{
    /**
 * Handle the "creating" event.
 */
    public function creating(DiscussPost $discussPost): void
    {
        $discussPost->user_id = Auth::id();
    }

    /**
     * Handle the "updating" event.
     */
    public function updating(DiscussPost $discussPost): void
    {
        $discussPost->edited_user_id = Auth::id();
        $discussPost->is_edited = true;
        $discussPost->edit_count++;
    }

    /**
     * Handle the "deleting" event.
     */
    public function deleting(DiscussPost $discussPost): void
    {
        $discussPost->loadMissing('conversation');
        $conversation = $discussPost->conversation;

        /*if ($conversation->first_post_id === $discussPost->getKey()) {
            $conversation->delete();
        }*/

        if ($conversation->last_post_id === $discussPost->getKey()) {
            $previousPost = DiscussPostRepository::findPreviousPost($discussPost, true);

            $conversation->last_post_id = !is_null($previousPost) ? $previousPost->getKey() : null;
        }

        if ($conversation->solved_post_id === $discussPost->getKey()) {
            $conversation->solved_post_id = null;
            $conversation->is_solved = false;
        }

        $conversation->save();
    }
}

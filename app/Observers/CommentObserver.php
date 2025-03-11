<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\BlogComment;

class CommentObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(BlogComment $comment): void
    {
        if (is_null($comment->user_id)) {
            $comment->user_id = Auth::id();
        }
    }
}

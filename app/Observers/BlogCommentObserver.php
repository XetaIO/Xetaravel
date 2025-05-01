<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\BlogComment;

class BlogCommentObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(BlogComment $comment): void
    {
        $comment->user_id = Auth::id();
    }
}

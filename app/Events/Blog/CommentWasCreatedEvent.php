<?php

declare(strict_types=1);

namespace Xetaravel\Events\Blog;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\User;

class CommentWasCreatedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public BlogComment $blogComment
    ) {
    }
}

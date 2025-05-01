<?php

declare(strict_types=1);

namespace Xetaravel\Events\Discuss;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class PostWasSolvedEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public DiscussPost $discussPost
    ) {
    }
}

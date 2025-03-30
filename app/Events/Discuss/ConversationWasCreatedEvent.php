<?php

declare(strict_types=1);

namespace Xetaravel\Events\Discuss;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class ConversationWasCreatedEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public User $user,
        public DiscussConversation $discussConversation
    ) {
    }
}

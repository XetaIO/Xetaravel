<?php

declare(strict_types=1);

namespace Xetaravel\Events\Discuss;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\DiscussConversation;

class TitleWasChangedEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public DiscussConversation $discussConversation,
        public string $title,
        public string $oldTitle
    ) {
    }
}

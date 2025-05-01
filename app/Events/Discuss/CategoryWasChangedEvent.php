<?php

declare(strict_types=1);

namespace Xetaravel\Events\Discuss;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\DiscussConversation;

class CategoryWasChangedEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public DiscussConversation $discussConversation,
        public int $category,
        public int $oldCategory
    ) {
    }
}

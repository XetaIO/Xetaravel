<?php

declare(strict_types=1);

namespace Xetaravel\Events\Discuss;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\DiscussConversation;

class CategoryWasChangedEvent
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

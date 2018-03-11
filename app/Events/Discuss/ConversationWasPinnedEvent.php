<?php
namespace Xetaravel\Events\Discuss;

use Xetaravel\Models\DiscussConversation;

class ConversationWasPinnedEvent
{
    /**
     * The conversation instance.
     *
     * @var \Xetaravel\Models\DiscussConversation
     */
    public $conversation;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussConversation $conversation
     */
    public function __construct(DiscussConversation $conversation)
    {
        $this->conversation = $conversation;
    }
}

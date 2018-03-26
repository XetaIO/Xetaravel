<?php
namespace Xetaravel\Events\Experiences;

use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class ConversationWasCreatedEvent
{
    /**
     * The conversation instance.
     *
     * @var \Xetaravel\Models\DiscussConversation
     */
    public $conversation;

    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussConversation $conversation
     * @param \Xetaravel\Models\User $user
     */
    public function __construct(DiscussConversation $conversation, User $user)
    {
        $this->conversation = $conversation;
        $this->user = $user;
    }
}

<?php
namespace Xetaravel\Events\Discuss;

use Xetaravel\Models\DiscussConversation;

class TitleWasChangedEvent
{
    /**
     * The conversation instance.
     *
     * @var \Xetaravel\Models\DiscussConversation
     */
    public $conversation;

    /**
     * The new title.
     *
     * @var string
     */
    public $title;

    /**
     * The old title.
     *
     * @var string
     */
    public $oldTitle;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussConversation $conversation
     * @param string $title
     * @param string $oldTitle
     */
    public function __construct(DiscussConversation $conversation, string $title, string $oldTitle)
    {
        $this->conversation = $conversation;
        $this->title = $title;
        $this->oldTitle = $oldTitle;
    }
}

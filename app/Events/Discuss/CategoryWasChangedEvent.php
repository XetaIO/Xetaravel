<?php
namespace Xetaravel\Events\Discuss;

use Xetaravel\Models\DiscussConversation;

class CategoryWasChangedEvent
{
    /**
     * The conversation instance.
     *
     * @var \Xetaravel\Models\DiscussConversation
     */
    public $conversation;

    /**
     * The new category id.
     *
     * @var int
     */
    public $category;

    /**
     * The old category id.
     *
     * @var int
     */
    public $oldCategory;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussConversation $conversation
     * @param int $category
     * @param int $oldCategory
     *
     */
    public function __construct(DiscussConversation $conversation, int $category, int $oldCategory)
    {
        $this->conversation = $conversation;
        $this->category = $category;
        $this->oldCategory = $oldCategory;
    }
}

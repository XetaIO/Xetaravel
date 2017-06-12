<?php
namespace Xetaravel\Events\Discuss;

use Xetaravel\Models\DiscussComment;
use Xetaravel\Models\User;

class CommentWasDeletedEvent
{
    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * The comment instance.
     *
     * @var \Xetaravel\Models\DiscussComment
     */
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussComment $comment
     * @param \Xetaravel\Models\User $user
     */
    public function __construct(DiscussComment $comment, User $user)
    {
        $this->comment = $comment;
        $this->user = $user;
    }
}

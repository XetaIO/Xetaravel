<?php
namespace Xetaravel\Events\Discuss;

use Xetaravel\Models\DiscussThread;
use Xetaravel\Models\User;

class ThreadWasLockedEvent
{
    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * The thread instance.
     *
     * @var \Xetaravel\Models\DiscussThread
     */
    public $thread;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussThread $thread
     * @param \Xetaravel\Models\User $user
     */
    public function __construct(DiscussThread $thread, User $user)
    {
        $this->thread = $thread;
        $this->user = $user;
    }
}

<?php
namespace Xetaravel\Events\Experiences;

use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class PostWasSolvedEvent
{
    /**
     * The post instance.
     *
     * @var \Xetaravel\Models\DiscussPost
     */
    public $post;

    /**
     * The user instance.
     *
     * @var \Xetaravel\Models\User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\DiscussPost $post
     * @param \Xetaravel\Models\User $user
     */
    public function __construct(DiscussPost $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }
}

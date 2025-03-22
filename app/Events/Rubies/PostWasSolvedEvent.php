<?php

declare(strict_types=1);

namespace Xetaravel\Events\Rubies;

use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;

class PostWasSolvedEvent
{
    /**
     * The post instance.
     *
     * @var DiscussPost
     */
    public $post;

    /**
     * The user instance.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param DiscussPost $post
     * @param User $user
     */
    public function __construct(DiscussPost $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }
}

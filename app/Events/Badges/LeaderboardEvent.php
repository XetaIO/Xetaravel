<?php
namespace Xetaravel\Events\Badges;

use Xetaravel\Models\User;

class LeaderboardEvent
{
    public $user;

    /**
     * Create a new event instance.
     *
     * @param \Xetaravel\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

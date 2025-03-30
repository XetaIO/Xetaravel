<?php

declare(strict_types=1);

namespace Xetaravel\Events\Badges;

use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\User;

class LeaderboardEvent implements ShouldDispatchAfterCommit
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public User $user)
    {
    }
}

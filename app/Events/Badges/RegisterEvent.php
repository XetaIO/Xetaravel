<?php

declare(strict_types=1);

namespace Xetaravel\Events\Badges;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Xetaravel\Models\User;

class RegisterEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public User $user)
    {
    }
}

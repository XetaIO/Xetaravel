<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\DiscussUser;

class DiscussUserObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(DiscussUser $discussUser): void
    {
        if (is_null($discussUser->user_id)) {
            $discussUser->user_id = Auth::id();
        }
    }
}

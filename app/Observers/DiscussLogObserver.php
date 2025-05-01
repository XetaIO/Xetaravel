<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\DiscussLog;

class DiscussLogObserver
{
    /**
     * Handle the "creating" event.
     */
    public function creating(DiscussLog $discussLog): void
    {
        if (is_null($discussLog->user_id)) {
            $discussLog->user_id = Auth::id();
        }
    }
}

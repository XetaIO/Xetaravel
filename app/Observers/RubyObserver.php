<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Ruby;

class RubyObserver
{
    /**
     * Handle the Ruby "creating" event.
     */
    public function creating(Ruby $ruby): void
    {
        if (is_null($ruby->user_id)) {
            $ruby->user_id = Auth::id();
        }
    }
}

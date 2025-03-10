<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Experience;

class ExperienceObserver
{
    /**
     * Handle the Ruby "creating" event.
     */
    public function creating(Experience $experience): void
    {
        if (is_null($experience->user_id)) {
            $experience->user_id = Auth::id();
        }
    }
}

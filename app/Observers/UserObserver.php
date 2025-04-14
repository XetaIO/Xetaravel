<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\User;

class UserObserver
{
    /**
     * Handle the "deleting" event.
     */
    public function deleting(User $user): void
    {
        if (Auth::id() !== $user->id) {
            $user->deleted_user_id = Auth::id();
        }
    }
}

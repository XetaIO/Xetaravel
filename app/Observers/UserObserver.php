<?php

declare(strict_types=1);

namespace Xetaravel\Observers;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\User;

class UserObserver
{
    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        if (auth()->user()) {
            $user->deleted_user_id = Auth::id();
            $user->save();
        }
    }

    /**
     * Handle the "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($user)
                ->event('deleted')
                ->withProperties(['attributes' => $user->toArray()])
                ->log('L\'utilisateur :causer.full_name à supprimé l\'utilisateur :subject.full_name.');
        }
    }
}

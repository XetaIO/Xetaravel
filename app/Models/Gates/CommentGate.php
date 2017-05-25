<?php
namespace Xetaravel\Models\Gates;

use Carbon\Carbon;
use Xetaravel\Models\User;
use Xetaravel\Models\Comment;

trait CommentGate
{
    /**
     * Check whatever the user is flooding or not. (We check for all articles)
     *
     * @param \Xetaravel\Models\User $user The user to check.
     *
     * @return bool
     */
    public static function isFlooding(User $user): bool
    {
        return Comment::where('user_id', $user->id)
            ->where(
                'created_at',
                '>=',
                Carbon::now()->subSeconds(config('xetaravel.flood.blog.comment'))
            )
            ->exists();
    }
}

<?php
namespace Xetaravel\Models\Gates;

use Carbon\Carbon;
use Xetaravel\Models\User;

trait FloodGate
{
    /**
     * Check whatever the user is flooding or not.
     *
     * @param \Xetaravel\Models\User $user The user to check.
     * @param string $rule The configuration rule to use.
     *
     * @return bool
     */
    public static function isFlooding(User $user, string $rule = 'xetaravel.flood.general'): bool
    {
        $class = get_called_class();

        return $class::where('user_id', $user->id)
            ->where(
                'created_at',
                '>=',
                Carbon::now()->subSeconds(config($rule))
            )
            ->exists();
    }
}

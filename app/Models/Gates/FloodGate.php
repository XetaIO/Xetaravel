<?php
namespace Xetaravel\Models\Gates;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait FloodGate
{
    /**
     * Check whatever the user is flooding or not.
     *
     * @param string $rule The configuration rule to use.
     *
     * @return bool
     */
    public static function isFlooding(string $rule = 'xetaravel.flood.general'): bool
    {
        $class = get_called_class();
        $user = Auth::user();

        return $class::where('user_id', $user->id)
            ->where(
                'created_at',
                '>=',
                Carbon::now()->subSeconds(config($rule))
            )
            ->exists();
    }
}

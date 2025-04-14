<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTomany;

class Badge extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'type',
        'rule'
    ];

    /**
     * Get the users that owns the badge.
     *
     * @return BelongsTomany
     */
    public function users(): BelongsTomany
    {
        return $this->belongsToMany(User::class)->withTrashed();
    }

    /**
     * Check if the given user has unlocked this badge.
     *
     * @param User $user The user to check.
     *
     * @return bool
     */
    public function hasUser(User $user): bool
    {
        return $this->users()
            ->where('user_id', $user->getKey())
            ->exists();
    }
}

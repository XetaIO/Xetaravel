<?php
namespace Xetaravel\Models;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTomany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Check if the given user has unlocked this badge.
     *
     * @return bool
     */
    public function hasUser($user)
    {
        return $this->users()
            ->where('user_id', $user->getKey())
            ->exists();
    }
}

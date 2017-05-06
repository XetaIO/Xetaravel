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
        'image',
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
}

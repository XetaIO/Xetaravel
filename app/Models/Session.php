<?php
namespace Xetaravel\Models;

class Session extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity',
        'url',
        'method'
    ];

    /**
     * Scope a query to only include non expired session.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpires($query)
    {
        $timeout = 5; // Timeout in minutes

        $expire = time() - (60 * $timeout);
        return $query->where('last_activity', '>=', $expire);
    }
}

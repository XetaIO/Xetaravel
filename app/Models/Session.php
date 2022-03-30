<?php
namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Builder;

class Session extends Model
{

    /**
     * Indicates if the ID are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

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
        'method',
        'infos',
        'created_at'
    ];

    /**
     * Scope a query to only include non expired session.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeExpires(Builder $query)
    {
        $timeout = 5; // Timeout in minutes

        $expire = time() - (60 * $timeout);
        return $query->where('last_activity', '>=', $expire);
    }
}

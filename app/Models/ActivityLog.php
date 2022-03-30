<?php
namespace Xetaravel\Models;

class ActivityLog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'url',
        'method',
        'ip',
        'user_agent',
        'last_activity'
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

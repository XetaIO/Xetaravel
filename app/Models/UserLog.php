<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'steam_id',
        'loggable_id',
        'loggable_type',
        'event_type',
        'data'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * Get the user that owns the log.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the loggable relation.
     *
     * @return MorphTo
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}

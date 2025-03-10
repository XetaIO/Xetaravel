<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Xetaravel\Observers\RubyObserver;

#[ObservedBy([RubyObserver::class])]
class Ruby extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'obtainable_id',
        'obtainable_type',
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
     * Get the obtainable relation.
     *
     * @return MorphTo
     */
    public function obtainable(): MorphTo
    {
        return $this->morphTo();
    }
}

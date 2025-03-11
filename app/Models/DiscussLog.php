<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Xetaravel\Models\Presenters\DiscussLogPresenter;
use Xetaravel\Observers\DiscussLogObserver;

#[ObservedBy([DiscussLogObserver::class])]
class DiscussLog extends Model
{
    use DiscussLogPresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'loggable_id',
        'loggable_type',
        'event_type',
        'data'
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'data' => 'array'
        ];
    }

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

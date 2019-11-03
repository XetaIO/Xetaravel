<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\SumCache\Summable;
use Illuminate\Support\Facades\Auth;

class Experience extends Model
{
    use Summable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set the user id to the new log before saving it.
        static::creating(function ($model) {
            if (is_null($model->user_id)) {
                $model->user_id = Auth::id();
            }
        });
    }

    /**
     * Return the sum cache configuration.
     *
     * @return array
     */
    public function sumCaches()
    {
        return [
            'experiences_total' => [User::class, 'amount', 'user_id', 'id']
        ];
    }

    /**
     * Get the user that owns the log.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the obtainable relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function obtainable()
    {
        return $this->morphTo();
    }
}

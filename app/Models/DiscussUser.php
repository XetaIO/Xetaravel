<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Xetaravel\Observers\DiscussUserObserver;

#[ObservedBy([DiscussUserObserver::class])]
class DiscussUser extends Model
{
    use HasCounts;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'conversation_id'
    ];

    /**
     * Get the user that owns the user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the conversation that owns the user.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'user_count')]
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(DiscussConversation::class);
    }
}

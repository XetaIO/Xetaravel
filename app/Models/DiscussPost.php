<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Gates\FloodGate;
use Xetaravel\Models\Presenters\DiscussPostPresenter;
use Xetaravel\Observers\DiscussPostObserver;

#[ObservedBy([DiscussPostObserver::class])]
class DiscussPost extends Model
{
    use DiscussPostPresenter;
    use FloodGate;
    use HasCounts;
    use HasMentionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'conversation_id',
        'content',
        'is_edited'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'content_markdown',
        'post_url'
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_edited' => 'boolean',
            'edited_at' => 'datetime'
        ];
    }

    /**
     * Get the user that owns the post.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'discuss_post_count')]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the conversation that owns the post.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'post_count')]
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(DiscussConversation::class);
    }

    /**
     * Get the user that edited the post.
     *
     * @return HasOne
     */
    public function editedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id');
    }
}

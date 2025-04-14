<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Eloquence\Behaviours\HasSlugs;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Gates\FloodGate;
use Xetaravel\Models\Presenters\DiscussConversationPresenter;
use Xetaravel\Models\Repositories\DiscussPostRepository;
use Xetaravel\Observers\DiscussConversationObserver;

#[ObservedBy([DiscussConversationObserver::class])]
class DiscussConversation extends Model
{
    use DiscussConversationPresenter;
    use FloodGate;
    use HasCounts;
    use HasMentionsTrait;
    use HasSlugs;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'is_locked',
        'is_pinned',
        'is_solved',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'conversation_url',
        'last_page'
    ];

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'edited_at' => 'datetime',
            'is_locked' => 'boolean',
            'is_pinned' => 'boolean',
            'is_solved' => 'boolean',
            'is_edited' => 'boolean',
        ];
    }

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy(): string
    {
        return 'title';
    }

    /**
     * Get the category that owns the conversation.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'conversation_count')]
    public function category(): BelongsTo
    {
        return $this->belongsTo(DiscussCategory::class);
    }

    /**
     * Get the user that owns the conversation.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'discuss_conversation_count')]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the posts for the conversation.
     *
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(DiscussPost::class, 'conversation_id', 'id');
    }

    /**
     * Get the users for the conversation.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(DiscussUser::class, 'conversation_id', 'id');
    }

    /**
     * Get the first post of the conversation.
     *
     * @return HasOne
     */
    public function firstPost(): HasOne
    {
        return $this->hasOne(DiscussPost::class, 'id', 'first_post_id');
    }

    /**
     * Get the solved post of the conversation.
     *
     * @return HasOne
     */
    public function solvedPost(): HasOne
    {
        return $this->hasOne(DiscussPost::class, 'id', 'solved_post_id');
    }

    /**
     * Get the last post of the conversation.
     *
     * @return HasOne
     */
    public function lastPost(): HasOne
    {
        return $this->hasOne(DiscussPost::class, 'id', 'last_post_id');
    }

    /**
     * Get the user that edited the conversation.
     *
     * @return HasOne
     */
    public function editedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id')->withTrashed();
    }

    /**
     * Get the discuss logs for the conversation.
     *
     * @return MorphMany
     */
    public function discussLogs(): MorphMany
    {
        return $this->morphMany(DiscussLog::class, 'loggable');
    }

    /**
     * Get the logs and posts related to the current conversation
     * for the given pagination posts and return the data
     * ordered by `created_at` as a Collection.
     *
     * @param Collection $posts
     * @param int $page
     *
     * @return Collection
     */
    public function getPostsWithLogs(Collection $posts, int $page): Collection
    {
        $logs = DiscussLog::query()
            ->with('user.account')
            ->where([
                'loggable_type' => get_class($this),
                'loggable_id' => $this->getKey(),
            ]);

        // When there are several pages and the current page is not the first and not the last.
        if ($this->lastPage > $page && $page !== 1) {
            $previousPost = DiscussPostRepository::findPreviousPost($posts->first());

            $logs = $logs
                ->where('created_at', '<=', $posts->last()->created_at)
                ->where('created_at', '>=', $previousPost->created_at);

            // When there are only one page.
        } elseif ($this->lastPage === 1) {
            $logs = $logs
                ->where('created_at', '>=', $this->created_at);

            // When there are several pages and the current page is the first page.
        } elseif ($page === 1) {
            $logs = $logs
                ->where('created_at', '<=', $posts->last()->created_at);

            // When there are several page and the current page is the last page
        } elseif ($page === $this->lastPage) {
            $previousPost = DiscussPostRepository::findPreviousPost($posts->first());

            $logs = $logs
                ->where('created_at', '>', $previousPost->created_at);
        }
        $postsWithLogs = $posts->merge($logs->get())->sortBy('created_at');

        // If the conversation has a solved post, prepend it
        // then prepend the first post to the collection
        if ($this->lastPage === 1 || $page === 1) {
            if (!is_null($this->solved_post_id)) {
                $postsWithLogs->prepend(DiscussPost::findOrFail($this->solved_post_id));
            }
            $postsWithLogs->prepend(DiscussPost::findOrFail($this->first_post_id));
        }

        return $postsWithLogs;
    }
}

<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\Sluggable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Gates\FloodGate;
use Xetaravel\Models\Presenters\DiscussThreadPresenter;
use Xetaravel\Models\Scopes\DisplayScope;
use Xetaravel\Models\User;

class DiscussThread extends Model
{
    use Countable,
        Sluggable,
        FloodGate,
        DiscussThreadPresenter,
        HasMentionsTrait;

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
        'content',
        'comment_count',
        'is_locked',
        'is_pinned',
        'is_solved',
        'is_edited'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'thread_url',
        'last_page'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'edited_at'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->generateSlug();
        });

        // Set the user id to the new thread before saving it.
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
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
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            'discuss_thread_count' => [User::class, 'user_id', 'id'],
            'thread_count' => [DiscussCategory::class, 'category_id', 'id']
        ];
    }

    /**
     * Get the category that owns the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(DiscussCategory::class);
    }

    /**
     * Get the user that owns the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(DiscussComment::class, 'thread_id', 'id');
    }

    /**
     * Get the solved comment of the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function solvedComment()
    {
        return $this->hasOne(DiscussComment::class, 'id', 'solved_comment_id');
    }

    /**
     * Get the last comment of the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastComment()
    {
        return $this->hasOne(DiscussComment::class, 'id', 'last_comment_id');
    }

    /**
     * Get the user that edited the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function editedUser()
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id');
    }

    /**
     * Get the discuss logs for the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function discussLogs()
    {
        return $this->morphMany(DiscussLog::class, 'loggable');
    }

    /**
     * Get the logs and comments related to the current thread
     * for the given the pagination comments and return the data
     * ordered by `created_at` as a Collection.
     *
     * @param \Illuminate\Support\Collection $comments
     * @param int $page
     *
     * @return \Illuminate\Support\Collection
     */
    public function getCommentWithLogs(Collection $comments, int $page): Collection
    {
        $logs = DiscussLog::where([
            'loggable_type' => get_class($this),
            'loggable_id' => $this->getKey(),
        ]);

        if ($comments->isEmpty()) {
            return $comments->merge($logs->get())->sortBy('created_at');
        }
        $previousComment = $this->getPreviousComment($comments->last()->created_at);

        // When there're several pages and the current page is not the first and not the last.
        if ($this->lastPage > $page && $page !== 1) {
            $logs = $logs->where('created_at', '<=', $comments->last()->created_at)
                ->where('created_at', '>=', $previousComment->created_at);

        // When there're only one page.
        } elseif ($this->lastPage == 1) {
            $logs = $logs->where('created_at', '>=', $this->created_at);

        // When there're several pages and the current page is the first page.
        } elseif ($page == 1) {
            $logs = $logs->where('created_at', '<=', $comments->last()->created_at);

        // When there're several page and the current page is the last page
        } elseif ($page == $this->lastPage) {
            $logs = $logs->where('created_at', '>=', $previousComment->created_at);
        }
        $logs = $logs->get();

        $commentsWithLogs = $comments->merge($logs);

        return $commentsWithLogs->sortBy('created_at');
    }

    /**
     * Get the previous comment related to the current thread with
     * the given date.
     *
     * @param string $createdAt
     *
     * @return \Xetaravel\Models\DiscussComment|null
     */
    protected function getPreviousComment(string $createdAt)
    {
        return DiscussComment::where('id', '!=', $this->solved_comment_id)
                ->where('created_at', '<', $createdAt)
                ->orderBy('created_at', 'desc')
                ->first();
    }
}

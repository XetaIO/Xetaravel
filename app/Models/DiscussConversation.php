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
use Xetaravel\Models\Presenters\DiscussConversationPresenter;
use Xetaravel\Models\Repositories\DiscussConversationRepository;
use Xetaravel\Models\Repositories\DiscussPostRepository;
use Xetaravel\Models\Scopes\DisplayScope;
use Xetaravel\Models\User;

class DiscussConversation extends Model
{
    use Countable,
        Sluggable,
        FloodGate,
        DiscussConversationPresenter,
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
        'post_count',
        'participants_count',
        'is_locked',
        'is_pinned',
        'is_solved',
        'is_edited',
        'edit_count'
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

        // Set the user id to the new conversation before saving it.
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->generateSlug();
        });

        // Handle the before deleting the conversation.
        static::deleting(function ($model) {
            $category = $model->category;

            // If the conversation is the last_conversation of the category,
            // find the new last_conversation and update the category.
            if ($category->last_conversation_id == $model->getKey()) {
                $previousConversation = DiscussConversationRepository::findPreviousConversation($model);

                if (is_null($previousConversation)) {
                    $category->last_conversation_id = null;
                } else {
                    $category->last_conversation_id = $previousConversation->getKey();
                }

                $category->save();
            }

            // Set the forgein keys to null, else it won't delete since it delete
            // the posts before the conversation.
            $model->first_post_id = null;
            $model->last_post_id = null;
            $model->solved_post_id = null;
            $model->save();

            // We need to do this to refresh the countable cache `discuss_post_count` of the user.
            foreach ($model->posts as $post) {
                $post->delete();
            }

            // It don't delete the logs, so we need to do it manually.
            foreach ($model->discussLogs as $log) {
                $log->delete();
            }
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
            'discuss_conversation_count' => [User::class, 'user_id', 'id'],
            'conversation_count' => [DiscussCategory::class, 'category_id', 'id']
        ];
    }

    /**
     * Get the category that owns the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(DiscussCategory::class);
    }

    /**
     * Get the user that owns the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the posts for the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(DiscussPost::class, 'conversation_id', 'id');
    }

    /**
     * Get the users for the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(DiscussUser::class, 'conversation_id', 'id');
    }

    /**
     * Get the first post of the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function firstPost()
    {
        return $this->hasOne(DiscussPost::class, 'id', 'first_post_id');
    }

    /**
     * Get the solved post of the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function solvedPost()
    {
        return $this->hasOne(DiscussPost::class, 'id', 'solved_post_id');
    }

    /**
     * Get the last post of the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastPost()
    {
        return $this->hasOne(DiscussPost::class, 'id', 'last_post_id');
    }

    /**
     * Get the user that edited the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function editedUser()
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id');
    }

    /**
     * Get the discuss logs for the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function discussLogs()
    {
        return $this->morphMany(DiscussLog::class, 'loggable');
    }

    /**
     * Get the logs and posts related to the current conversation
     * for the given the pagination posts and return the data
     * ordered by `created_at` as a Collection.
     *
     * @param \Illuminate\Support\Collection $posts
     * @param int $page
     *
     * @return \Illuminate\Support\Collection
     */
    public function getPostsWithLogs(Collection $posts, int $page): Collection
    {
        $logs = DiscussLog::where([
            'loggable_type' => get_class($this),
            'loggable_id' => $this->getKey(),
        ]);

        if (!$posts->isEmpty()) {
            $previousPost = DiscussPostRepository::findPreviousPost($posts->first());
        }

        // When there're several pages and the current page is not the first and not the last.
        if ($this->lastPage > $page && $page !== 1) {
            $logs = $logs->where('created_at', '<=', $posts->last()->created_at)
                ->where('created_at', '>=', $previousPost->created_at);

        // When there're only one page.
        } elseif ($this->lastPage == 1) {
            $logs = $logs->where('created_at', '>=', $this->created_at);

        // When there're several pages and the current page is the first page.
        } elseif ($page == 1) {
            $logs = $logs->where('created_at', '<=', $posts->last()->created_at);

        // When there're several page and the current page is the last page
        } elseif ($page == $this->lastPage) {
            $logs = $logs->where('created_at', '>', $previousPost->created_at);
        }
        $postsWithLogs = $posts->merge($logs->get())->sortBy('created_at');

        // If the conversation has a solved post, prepend it
        // then prepend the first post to the collection
        if ($this->lastPage == 1 || $page == 1) {
            if (!is_null($this->solved_post_id)) {
                $postsWithLogs->prepend(DiscussPost::findOrFail($this->solved_post_id));
            }
            $postsWithLogs->prepend(DiscussPost::findOrFail($this->first_post_id));
        }

        return $postsWithLogs;
    }
}

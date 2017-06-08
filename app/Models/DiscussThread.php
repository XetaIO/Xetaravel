<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\Sluggable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Presenters\DiscussThreadPresenter;
use Xetaravel\Models\Scopes\DisplayScope;
use Xetaravel\Models\User;

class DiscussThread extends Model
{
    use Countable,
        Sluggable,
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
            User::class,
            DiscussCategory::class
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
        return $this->hasMany(DiscussComment::class);
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
}

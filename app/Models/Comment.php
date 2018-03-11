<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Models\Article;
use Xetaravel\Models\Gates\FloodGate;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Presenters\CommentPresenter;
use Xetaravel\Models\User;

class Comment extends Model
{
    use Countable,
        FloodGate,
        CommentPresenter,
        HasMentionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'content'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'content_markdown',
        'comment_url'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set the user id to the new comment before saving it.
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });
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
            Article::class
        ];
    }

    /**
     * Get the user that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the article that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}

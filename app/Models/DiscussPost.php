<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Support\Facades\Auth;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Gates\FloodGate;
use Xetaravel\Models\Presenters\DiscussPostPresenter;
use Xetaravel\Models\Repositories\DiscussPostRepository;

class DiscussPost extends Model
{
    use Countable,
        DiscussPostPresenter,
        FloodGate,
        HasMentionsTrait;

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

        // Set the user id to the new post before saving it.
        static::creating(function ($model) {
            $model->user_id = Auth::id();
        });

        static::deleting(function ($model) {
            $conversation = $model->conversation;

            if ($conversation->first_post_id == $model->getKey()) {
                $conversation->delete();
            }

            if ($conversation->last_post_id == $model->getKey()) {
                $previousPost = DiscussPostRepository::findPreviousPost($model, true);

                $conversation->last_post_id = !is_null($previousPost) ? $previousPost->getKey() : null;
            }

            if ($conversation->solved_post_id == $model->getKey()) {
                $conversation->solved_post_id = null;
                $conversation->is_solved = false;
            }

            $conversation->save();
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
            'discuss_post_count' => [User::class, 'user_id', 'id'],
            'post_count' => [DiscussConversation::class, 'conversation_id', 'id']
        ];
    }

    /**
     * Get the user that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the conversation that owns the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(DiscussConversation::class);
    }

    /**
     * Get the user that edited the post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function editedUser()
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id');
    }
}

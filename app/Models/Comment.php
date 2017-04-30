<?php
namespace Xetaravel\Models;

use Xetaravel\Models\Article;
use Xetaravel\Models\User;
use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Comment extends Model
{
    use Countable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id', 'user_id', 'content'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches()
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
        return $this->belongsTo('Xetaravel\Models\User');
    }

    /**
     * Get the article that owns the comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('Xetaravel\Models\Article');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public static function validator(array $data)
    {
        return Validator::make($data, [
            'content' => 'required|min:10',
            'article_id' => 'required'
        ]);
    }

    /**
     * Create a new comment instance after a valid validation.
     *
     * @param array $data The data used to create the comment.
     * @param \Xetaravel\Models\User $user The current user.
     *
     * @return \Xetaravel\Models\Comment
     */
    public static function createComment(array $data, $user)
    {
        return Comment::create([
            'article_id' => $data['article_id'],
            'user_id' => $user->id,
            'content' => $data['content']
        ]);
    }
}

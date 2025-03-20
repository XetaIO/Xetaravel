<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Gates\FloodGate;
use Xetaravel\Models\Presenters\CommentPresenter;
use Xetaravel\Observers\CommentObserver;

#[ObservedBy([CommentObserver::class])]
class BlogComment extends Model
{
    use CommentPresenter;
    use FloodGate;
    use HasCounts;
    use HasMentionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'blog_article_id',
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
     * Get the user that owns the comment.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'blog_comment_count')]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the article that owns the comment.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'blog_comment_count')]
    public function article(): BelongsTo
    {
        return $this->belongsTo(BlogArticle::class, 'blog_article_id');
    }
}

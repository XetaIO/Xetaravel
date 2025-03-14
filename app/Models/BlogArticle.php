<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Eloquence\Behaviours\HasSlugs;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Presenters\ArticlePresenter;
use Xetaravel\Observers\ArticleObserver;

#[ObservedBy([ArticleObserver::class])]
class BlogArticle extends Model implements HasMedia
{
    use ArticlePresenter;
    use HasMentionsTrait;
    use HasCounts;
    use HasSlugs;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'is_display',
        'content'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'article_url',

        // Media Model
        'article_banner'
    ];

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
     * Register the related to the Model.
     *
     * @param Media|null $media
     *
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('article.banner')
            ->fit(Fit::Contain, 870, 350)
            ->keepOriginalImageFormat()
            ->nonQueued();
    }

    /**
     * Get the category that owns the article.
     *
     * @return BelongsTo
     */
    #[CountedBy]
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    /**
     * Get the user that owns the article.
     *
     * @return BelongsTo
     */
    #[CountedBy]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the article.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }
}

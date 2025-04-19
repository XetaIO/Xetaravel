<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Eloquence\Behaviours\HasSlugs;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Xetaravel\Models\Presenters\CategoryPresenter;
use Xetaravel\Observers\BlogCategoryObserver;

#[ObservedBy([BlogCategoryObserver::class])]
class BlogCategory extends Model
{
    use CategoryPresenter;
    use HasSlugs;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'show_url'
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
     * Get the articles for the category.
     *
     * @return HasMany
     */
    public function articles(): HasMany
    {
        return $this->hasMany(BlogArticle::class);
    }
}

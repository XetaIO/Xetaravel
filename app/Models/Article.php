<?php
namespace Xetaravel\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\Sluggable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Xetaio\Mentions\Models\Traits\HasMentionsTrait;
use Xetaravel\Models\Category;
use Xetaravel\Models\Presenters\ArticlePresenter;
use Xetaravel\Models\Scopes\DisplayScope;
use Xetaravel\Models\User;

class Article extends Model
{
    use Countable,
        Sluggable,
        ArticlePresenter,
        HasMentionsTrait;

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
        'article_url'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // The Route::getPrefix() is undefined in the testing environment for mysterious reasons.
        if (App::environment() !== 'testing') {
            // Don't apply the scope to the admin part.
            $result = strpos(Route::getFacadeRoot()->current()->getPrefix(), 'admin');
            if ($result === false) {
                static::addGlobalScope(new DisplayScope);
            }
        }

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->generateSlug();
        });

        // Set the user id to the new article before saving it.
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
            Category::class
        ];
    }

    /**
     * Get the category that owns the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user that owns the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the comments for the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

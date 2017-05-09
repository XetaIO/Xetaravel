<?php
namespace Xetaravel\Models;

use Xetaravel\Models\Category;
use Xetaravel\Models\User;
use Xetaravel\Models\Scopes\DisplayScope;
use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\Sluggable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class Article extends Model
{
    use Countable,
        Sluggable;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * The Route::getFacadeRoot() is undefined in the testing environment for mysterious reasons.
         */
        if (App::environment() != 'testing') {
            // Don't apply the scope to the admin part.
            if (Route::getFacadeRoot()->current()->getPrefix() != '/admin') {
                static::addGlobalScope(new DisplayScope);
            }
        } else {
            static::addGlobalScope(new DisplayScope);
        }
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

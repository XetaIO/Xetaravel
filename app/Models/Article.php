<?php
namespace Xetaravel\Models;

use Xetaravel\Models\Category;
use Xetaravel\Models\User;
use Xetaravel\Models\Scopes\DisplayScope;
use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;

class Article extends Model
{
    use Countable;

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
        return $this->belongsTo('Xetaravel\Models\Category');
    }

    /**
     * Get the user that owns the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Xetaravel\Models\User');
    }

    /**
     * Get the comments for the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('Xetaravel\Models\Comment');
    }
}

<?php
namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Countable;

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches()
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
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Get the user that owns the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the comments for the article.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Find the latest articles for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function sidebar()
    {
        return Article::latest()->take(5)->get();
    }
}

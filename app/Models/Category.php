<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquence\Behaviours\Sluggable;

class Category extends Model
{
    use Sluggable;

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy()
    {
        return 'title';
    }

    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    /**
     * Find the categories for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function sidebar()
    {
        return Category::take(25)->orderBy('title', 'asc')->get();
    }
}

<?php

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\BlogCategory;

class CategoryRepository
{
    /**
     * Find the categories for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function sidebar(): Collection
    {
        return BlogCategory::take(config('xetaravel.blog.categories_sidebar'))->orderBy('title', 'asc')->get();
    }
}

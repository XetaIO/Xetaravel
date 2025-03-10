<?php

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\DiscussCategory;

class DiscussCategoryRepository
{
    /**
     * Find the categories for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function sidebar(): Collection
    {
        return DiscussCategory::take(config('xetaravel.discuss.categories_sidebar'))->orderBy('level', 'asc')->get();
    }
}

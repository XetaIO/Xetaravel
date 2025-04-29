<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\BlogCategory;

class BlogCategoryRepository
{
    /**
     * Find the categories for the sidebar.
     *
     * @return Collection
     */
    public static function sidebar(): Collection
    {
        return BlogCategory::take(config('xetaravel.blog.categories_sidebar'))->orderBy('title', 'asc')->get();
    }
}

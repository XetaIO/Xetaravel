<?php

declare(strict_types=1);

namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\DiscussCategory;

class DiscussCategoryRepository
{
    /**
     * Find the categories for the sidebar.
     *
     * @return Collection
     */
    public static function sidebar(): Collection
    {
        return DiscussCategory::take(config('xetaravel.discuss.categories_sidebar'))->orderBy('level', 'asc')->get();
    }
}

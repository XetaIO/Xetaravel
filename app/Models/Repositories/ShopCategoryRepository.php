<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\ShopCategory;

class ShopCategoryRepository
{
    /**
     * Find the shop categories for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function sidebar(): Collection
    {
        return ShopCategory::take(config('xetaravel.shop.categories_sidebar'))->orderBy('title', 'asc')->get();
    }

    /**
     * Create the new category and save it.
     *
     * @param array $data The data used to create the category.
     *
     * @return \Xetaravel\Models\ShopCategory
     */
    public static function create(array $data): ShopCategory
    {
    }

    /**
     * Update the category data and save it.
     *
     * @param array $data The data used to update the category.
     * @param \Xetaravel\Models\ShopCategory $category The category to update.
     *
     * @return bool
     */
    public static function update(array $data, ShopCategory $category): bool
    {
    }
}

<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Collection;
use Xetaravel\Models\Category;

class CategoryRepository
{
    /**
     * Find the categories for the sidebar.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function sidebar(): Collection
    {
        return Category::take(config('xetaravel.blog.categories_sidebar'))->orderBy('title', 'asc')->get();
    }

    /**
     * Create the new category and save it.
     *
     * @param array $data The data used to create the category.
     *
     * @return \Xetaravel\Models\Category
     */
    public static function create(array $data): Category
    {
        return Category::create([
            'title' => $data['title'],
            'description' => $data['description']
        ]);
    }

    /**
     * Update the category data and save it.
     *
     * @param array $data The data used to update the category.
     * @param \Xetaravel\Models\Category $category The category to update.
     *
     * @return bool
     */
    public static function update(array $data, Category $category): bool
    {
        $category->title = $data['title'];
        $category->description = $data['description'];

        return $category->save();
    }
}

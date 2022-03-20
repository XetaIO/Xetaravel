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

    /**
     * Create the new category and save it.
     *
     * @param array $data The data used to create the category.
     *
     * @return \Xetaravel\Models\DiscussCategory
     */
    public static function create(array $data) : DiscussCategory
    {
        return DiscussCategory::create([
            'title' => $data['title'],
            'color' => $data['color'],
            'is_locked' => isset($data['is_locked']) ? true : false,
            'level' => $data['level'],
            'description' => $data['description']
        ]);
    }

    /**
     * Update the category data and save it.
     *
     * @param array $data The data used to update the category.
     * @param \Xetaravel\Models\DiscussCategory $category The category to update.
     *
     * @return bool
     */
    public static function update(array $data, DiscussCategory $category) : bool
    {
        $category->title = $data['title'];
        $category->color = $data['color'];
        $category->is_locked = isset($data['is_locked']) ? true : false;
        $category->description = $data['description'];

        return $category->save();
    }
}

<?php
namespace Xetaravel\Models\Presenters;

trait ShopCategoryPresenter
{
    /**
     * Get the category url.
     *
     * @return string
     */
    public function getCategoryUrlAttribute(): string
    {
        if (!isset($this->slug)) {
            return '';
        }

        return route('shop.category.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }
}

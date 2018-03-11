<?php
namespace Xetaravel\Models\Presenters;

trait DiscussCategoryPresenter
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

        return route('discuss.category.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }
}

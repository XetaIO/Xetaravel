<?php
namespace Xetaravel\Models\Presenters;

trait CategoryPresenter
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

        return route('blog.category.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }
}

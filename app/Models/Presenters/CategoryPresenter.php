<?php

declare(strict_types=1);

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
        if (!isset($this->slug) || $this->getKey() === null) {
            return '';
        }

        return route('blog.category.show', ['slug' => $this->slug, 'id' => $this->getKey()]);
    }
}

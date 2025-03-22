<?php

declare(strict_types=1);

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
        if ($this->getKey() === null) {
            return '';
        }

        return route('discuss.index', ['c' => $this->getKey()]);
    }
}

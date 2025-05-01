<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait DiscussCategoryPresenter
{
    /**
     * Get the category url.
     *
     * @return Attribute
     */
    protected function showUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('discuss.index', ['c' => $this->getKey()])
        );
    }
}

<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait CategoryPresenter
{
    /**
     * Get the category url.
     *
     * @return Attribute
     */
    protected function showUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => route('blog.category.show', ['slug' => $this?->slug, 'id' => $this?->getKey()])
        );
    }
}

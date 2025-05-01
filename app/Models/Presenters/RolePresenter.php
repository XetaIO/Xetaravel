<?php

declare(strict_types=1);

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait RolePresenter
{
    /**
     * Get the color of the role.
     *
     * @return Attribute
     */
    protected function formattedColor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->color ? "color:$this->color;" : ''
        );
    }
}

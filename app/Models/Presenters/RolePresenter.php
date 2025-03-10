<?php

namespace Xetaravel\Models\Presenters;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait RolePresenter
{
    /**
     * The default color used for role without color.
     *
     * @var string
     */
    protected string $defaultColor = '';

    /**
     * Get the color of the role.
     *
     * @return Attribute
     */
    protected function formattedColor(): Attribute
    {
        return Attribute::make(
            get: function () {
                $color = $this->color ?: $this->defaultColor;

                return 'color:' . $color . ';';
            }
        );
    }
}

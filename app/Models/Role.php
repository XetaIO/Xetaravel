<?php

declare(strict_types=1);

namespace Xetaravel\Models;

use Xetaravel\Models\Presenters\RolePresenter;
use \Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use RolePresenter;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_color',
    ];

}

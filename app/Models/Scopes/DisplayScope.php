<?php

declare(strict_types=1);

namespace Xetaravel\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DisplayScope implements Scope
{
    /**
     * Display scope for Eloquent Models.
     *
     * @param Builder $builder
     * @param Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('is_display', '=', true);
    }
}

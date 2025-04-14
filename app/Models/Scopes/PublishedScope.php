<?php

declare(strict_types=1);

namespace Xetaravel\Models\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PublishedScope implements Scope
{
    /**
     * Published scope for Eloquent Models.
     *
     * @param Builder $builder
     * @param Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('published_at', '<=', Carbon::now());
    }
}

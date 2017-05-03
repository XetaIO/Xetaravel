<?php
namespace Xetaravel\Models\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DisplayScope implements Scope
{
    /**
     * Display scope for Eloquent Models.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('is_display', '=', true);
    }
}

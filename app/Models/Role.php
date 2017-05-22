<?php
namespace Xetaravel\Models;

use Ultraware\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;
use Ultraware\Roles\Traits\RoleHasRelations;
use Ultraware\Roles\Traits\Slugable;

class Role extends Model implements RoleHasRelationsContract
{
    use Slugable, RoleHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'css',
        'level'
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generated the slug before updating.
        static::updating(function ($model) {
            $model->setSlugAttribute($model->name);
        });

        // Generated the slug before creating.
        static::creating(function ($model) {
            $model->setSlugAttribute($model->name);
        });
    }
}

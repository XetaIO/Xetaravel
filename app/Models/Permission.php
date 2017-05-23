<?php
namespace Xetaravel\Models;

use Ultraware\Roles\Contracts\PermissionHasRelations as PermissionHasRelationsContract;
use Ultraware\Roles\Traits\PermissionHasRelations;
use Ultraware\Roles\Traits\Slugable;

class Permission extends Model implements PermissionHasRelationsContract
{
    use Slugable, PermissionHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'model'
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

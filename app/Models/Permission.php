<?php
namespace Xetaravel\Models;

use Ultraware\Roles\Contracts\PermissionHasRelations as PermissionHasRelationsContract;
use Ultraware\Roles\Traits\PermissionHasRelations;

class Permission extends Model implements PermissionHasRelationsContract
{
    use PermissionHasRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'model',
        'is_deletable'
    ];

    /**
     * The attributes that should be cast has a certain type.
     *
     * @var array
     */
    protected $cast = [
        'is_deletable' => 'boolean'
    ];

    /**
     * Return the field to slug.
     *
     * @return string
     */
    public function slugStrategy(): string
    {
        return 'name';
    }
}

<?php
namespace Xetaravel\Models;

use Ultraware\Roles\Contracts\RoleHasRelations as RoleHasRelationsContract;
use Ultraware\Roles\Traits\RoleHasRelations;

class Role extends Model implements RoleHasRelationsContract
{
    use RoleHasRelations;

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
        'level',
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

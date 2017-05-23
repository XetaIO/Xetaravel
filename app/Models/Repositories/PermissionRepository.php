<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\Permission;

class PermissionRepository
{
    /**
     * Create a new permission instance.
     *
     * @param array $data The data used to create the permission.
     *
     * @return \Xetaravel\Models\Permission
     */
    public static function create(array $data): Permission
    {
        return Permission::create([
            'name' => $data['name'],
            'description' => $data['description']
        ]);
    }

    /**
     * Update the permission informations after a valid update request.
     *
     * @param array $data The data used to update the permission.
     * @param \Xetaravel\Models\Permission $permission The permission to update.
     *
     * @return bool
     */
    public static function update(array $data, Permission $permission): bool
    {
        $permission->name = $data['name'];
        $permission->description = $data['description'];

        return $permission->save();
    }
}

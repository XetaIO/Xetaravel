<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\Role;

class RoleRepository
{
    /**
     * Create a new role instance.
     *
     * @param array $data The data used to create the role.
     *
     * @return \Xetaravel\Models\Role
     */
    public static function create(array $data): Role
    {
        return Role::create([
            'name' => $data['name'],
            'css' => $data['css'],
            'level' => $data['level'],
            'description' => $data['description']
        ]);
    }

    /**
     * Update the role informations after a valid update request.
     *
     * @param array $data The data used to update the role.
     * @param \Xetaravel\Models\Role $role The role to update.
     *
     * @return bool
     */
    public static function update(array $data, Role $role): bool
    {
        $role->name = $data['name'];
        $role->description = $data['description'];
        $role->css = $data['css'];
        $role->level = $data['level'];

        return $role->save();
    }
}

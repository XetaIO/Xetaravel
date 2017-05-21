<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\Role;

class RoleRepository
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     *
     * @return \Xetaravel\Models\User
     */
    public static function create(array $data): User
    {
        $ip = FacadeRequest::ip();

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'register_ip' => $ip,
            'last_login_ip' => $ip,
            'last_login' => new \DateTime()
        ]);
    }

    /**
     * Update the role informations after a valid update request.
     *
     * @param array $data The data used to update the user.
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

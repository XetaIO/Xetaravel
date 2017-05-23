<?php

use Illuminate\Database\Seeder;
use Xetaravel\Models\Permission;
use Xetaravel\Models\Role;

class PermissionsRolesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin Role
        $role = Role::where('slug', 'administrator')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.users')->first());
        $role->attachPermission(Permission::where('slug', 'manage.roles')->first());
        $role->attachPermission(Permission::where('slug', 'manage.articles')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Editor Role
        $role = Role::where('slug', 'editor')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.articles')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // User Role
        $role = Role::where('slug', 'user')->first();
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Banished Role
        $role = Role::where('slug', 'banished')->first();
        $role->attachPermission(Permission::where('slug', 'show.banished')->first());
    }
}

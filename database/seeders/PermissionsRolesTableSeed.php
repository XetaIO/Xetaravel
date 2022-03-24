<?php
namespace Database\Seeders;

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
        // Developper Role
        $role = Role::where('slug', 'developer')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.users')->first());
        $role->attachPermission(Permission::where('slug', 'manage.roles')->first());
        $role->attachPermission(Permission::where('slug', 'manage.blog')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.conversations')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.categories')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.posts')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Admin Role
        $role = Role::where('slug', 'administrator')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.users')->first());
        $role->attachPermission(Permission::where('slug', 'manage.blog')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.conversations')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.categories')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.posts')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Moderator Role
        $role = Role::where('slug', 'moderator')->first();
        $role->attachPermission(Permission::where('slug', 'access.administration')->first());
        $role->attachPermission(Permission::where('slug', 'manage.blog')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.conversations')->first());
        $role->attachPermission(Permission::where('slug', 'manage.discuss.posts')->first());
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // User Role
        $role = Role::where('slug', 'user')->first();
        $role->attachPermission(Permission::where('slug', 'access.site')->first());

        // Banished Role
        $role = Role::where('slug', 'banished')->first();
        $role->attachPermission(Permission::where('slug', 'show.banished')->first());
    }
}

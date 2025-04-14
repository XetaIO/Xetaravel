<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Xetaravel\Models\Role;

class RoleHasPermissionsTableSeeder extends Seeder
{
    protected array $developerPermissions = [
        'bypass login',
        'access administration',

        // Blog Articles
        'viewAny blog article',
        'view blog article',
        'create blog article',
        'update blog article',
        'delete blog article',
        'search blog article',
        'manage blog article',

        // Blog Comments
        'create blog comment',
        'update blog comment',
        'delete blog comment',
        'manage blog comment',

        // Discuss Categories
        'viewAny discuss category',
        'view discuss category',
        'create discuss category',
        'update discuss category',
        'delete discuss category',
        'search discuss category',
        'manage discuss category',

        // Discuss Conversations
        'viewAny discuss conversation',
        'view discuss conversation',
        'create discuss conversation',
        'update discuss conversation',
        'delete discuss conversation',
        'search discuss conversation',
        'pin discuss conversation',
        'lock discuss conversation',
        'manage discuss conversation',

        // Discuss Posts
        'create discuss post',
        'update discuss post',
        'delete discuss post',
        'manage discuss post',

        // Users
        'viewAny user',
        'view user',
        'update user',
        'delete user',
        'assign-direct-permission user',
        'search user',
        'manage user',

        // Roles
        'viewAny role',
        'create role',
        'update role',
        'delete role',
        'search role',
        'manage role',

        // Permissions
        'viewAny permission',
        'create permission',
        'update permission',
        'delete permission',
        'search permission',
        'manage permission',

        // Settings
        'viewAny setting',
        'create setting',
        'update setting',
        'delete setting',
        'manage setting',
    ];

    protected array $administratorPermissions = [
        'bypass login',
        'access administration',

        // Blog Articles
        'viewAny blog article',
        'view blog article',
        'create blog article',
        'update blog article',
        'delete blog article',
        'search blog article',
        'manage blog article',

        // Blog Comments
        'create blog comment',
        'update blog comment',
        'delete blog comment',
        'manage blog comment',

        // Discuss Categories
        'viewAny discuss category',
        'view discuss category',
        'create discuss category',
        'update discuss category',
        'delete discuss category',
        'search discuss category',
        'manage discuss category',

        // Discuss Conversations
        'viewAny discuss conversation',
        'view discuss conversation',
        'create discuss conversation',
        'update discuss conversation',
        'delete discuss conversation',
        'search discuss conversation',
        'pin discuss conversation',
        'lock discuss conversation',
        'manage discuss conversation',

        // Discuss Posts
        'create discuss post',
        'update discuss post',
        'delete discuss post',
        'manage discuss post',

        // Users
        'viewAny user',
        'view user',
        'update user',
        'delete user',
        'assign-direct-permission user',
        'search user',
        'manage user',

        // Roles
        'viewAny role',
        'create role',
        'update role',
        'delete role',
        'search role',
        'manage role',

        // Permissions
        'viewAny permission',
        'search permission',
        'manage permission',

        // Settings
        'viewAny setting',
        'update setting',
        'manage setting',
    ];

    protected array $moderatorPermissions = [
        'bypass login',
        'access administration',

        // Blog Articles
        'viewAny blog article',
        'view blog article',
        'create blog article',
        'update blog article',
        'search blog article',
        'manage blog article',

        // Blog Comments
        'create blog comment',
        'update blog comment',
        'delete blog comment',
        'manage blog comment',

        // Discuss Categories
        'viewAny discuss category',
        'view discuss category',
        'search discuss category',

        // Discuss Conversations
        'viewAny discuss conversation',
        'view discuss conversation',
        'create discuss conversation',
        'update discuss conversation',
        'delete discuss conversation',
        'search discuss conversation',
        'pin discuss conversation',
        'lock discuss conversation',
        'manage discuss conversation',

        // Discuss Posts
        'create discuss post',
        'update discuss post',
        'delete discuss post',
        'manage discuss post',

        // Users
        'viewAny user',
        'view user',
        'update user',
        'search user'
    ];

    protected array $userPermissions = [
        // Blog Articles
        'viewAny blog article',
        'view blog article',
        'search blog article',

        // Blog Comments
        'create blog comment',
        'update blog comment',
        'delete blog comment',

        // Discuss Categories
        'viewAny discuss category',
        'view discuss category',
        'search discuss category',

        // Discuss Conversations
        'viewAny discuss conversation',
        'view discuss conversation',
        'create discuss conversation',
        'update discuss conversation',
        'delete discuss conversation',
        'search discuss conversation',

        // Discuss Posts
        'create discuss post',
        'update discuss post',
        'delete discuss post',

        // Users
        'view user',
        'search user'
    ];

    protected array $banishedPermissions = [
        'show banished'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Developer Role
        $role = Role::findByName('Developer');
        $role->syncPermissions($this->developerPermissions);

        // Admin Role
        $role = Role::findByName('Administrator');
        $role->syncPermissions($this->administratorPermissions);

        // Moderator Role
        $role = Role::findByName('Moderator');
        $role->syncPermissions($this->moderatorPermissions);

        // User Role
        $role = Role::findByName('User');
        $role->syncPermissions($this->userPermissions);

        // Banished Role
        $role = Role::findByName('Banished');
        $role->syncPermissions($this->banishedPermissions);

    }
}

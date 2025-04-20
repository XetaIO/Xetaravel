<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();
        $permissions = [
            [
                'name' => 'bypass login',
                'description' => 'The user can bypass the login when disabled.',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'access administration',
                'description' => 'The user can access to the administration.',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'show banished',
                'description' => 'The user is banished.',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Blog Articles
            [
                'name' => 'viewAny blog article',
                'guard_name' => 'web',
                'description' => 'The user can see the articles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'view blog article',
                'guard_name' => 'web',
                'description' => 'The user can see an article.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create blog article',
                'guard_name' => 'web',
                'description' => 'The user can create articles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update blog article',
                'guard_name' => 'web',
                'description' => 'The user can update articles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete blog article',
                'guard_name' => 'web',
                'description' => 'The user can delete articles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search blog article',
                'guard_name' => 'web',
                'description' => 'The user can search articles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage blog article',
                'guard_name' => 'web',
                'description' => 'The user can manage articles (update/delete from other users).',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Blog Categories
            [
                'name' => 'viewAny blog category',
                'guard_name' => 'web',
                'description' => 'The user can see the categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'view blog category',
                'guard_name' => 'web',
                'description' => 'The user can see an category.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create blog category',
                'guard_name' => 'web',
                'description' => 'The user can create categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update blog category',
                'guard_name' => 'web',
                'description' => 'The user can update categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete blog category',
                'guard_name' => 'web',
                'description' => 'The user can delete categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search blog category',
                'guard_name' => 'web',
                'description' => 'The user can search categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Blog Comments
            [
                'name' => 'create blog comment',
                'guard_name' => 'web',
                'description' => 'The user can create comments.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update blog comment',
                'guard_name' => 'web',
                'description' => 'The user can update comments.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete blog comment',
                'guard_name' => 'web',
                'description' => 'The user can delete comments.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage blog comment',
                'guard_name' => 'web',
                'description' => 'The user can manage comments (update/delete from other users).',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Discuss Categories
            [
                'name' => 'viewAny discuss category',
                'guard_name' => 'web',
                'description' => 'The user can see the discuss categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'view discuss category',
                'guard_name' => 'web',
                'description' => 'The user can see a discuss category.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create discuss category',
                'guard_name' => 'web',
                'description' => 'The user can create discuss categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update discuss category',
                'guard_name' => 'web',
                'description' => 'The user can update discuss categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete discuss category',
                'guard_name' => 'web',
                'description' => 'The user can delete discuss categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search discuss category',
                'guard_name' => 'web',
                'description' => 'The user can search discuss categories.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage discuss category',
                'guard_name' => 'web',
                'description' => 'The user can manage discuss category.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Discuss Conversations
            [
                'name' => 'viewAny discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can see the discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'view discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can see a discuss conversation.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can create discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can update discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can delete discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can search discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'pin discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can pin discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'lock discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can lock discuss conversations.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage discuss conversation',
                'guard_name' => 'web',
                'description' => 'The user can manage discuss conversations (update/delete from other users).',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Discuss Posts
            [
                'name' => 'create discuss post',
                'guard_name' => 'web',
                'description' => 'The user can create discuss posts.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update discuss post',
                'guard_name' => 'web',
                'description' => 'The user can update discuss posts.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete discuss post',
                'guard_name' => 'web',
                'description' => 'The user can delete discuss posts.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage discuss post',
                'guard_name' => 'web',
                'description' => 'The user can manage discuss posts (update/delete from other users).',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Users
            [
                'name' => 'viewAny user',
                'guard_name' => 'web',
                'description' => 'The user can see the users.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'view user',
                'guard_name' => 'web',
                'description' => 'The user can see an user.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update user',
                'guard_name' => 'web',
                'description' => 'The user can update an user',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete user',
                'guard_name' => 'web',
                'description' => 'The user can delete an user.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'restore user',
                'guard_name' => 'web',
                'description' => 'The user can restore an user.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'assign-direct-permission user',
                'guard_name' => 'web',
                'description' => 'The user can assign directs permissions to an user.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search user',
                'guard_name' => 'web',
                'description' => 'The user can search other users.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage user',
                'guard_name' => 'web',
                'description' => 'The user can manage other users (update/delete other users).',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Roles
            [
                'name' => 'viewAny role',
                'guard_name' => 'web',
                'description' => 'The user can see the roles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create role',
                'guard_name' => 'web',
                'description' => 'The user can create a role.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update role',
                'guard_name' => 'web',
                'description' => 'The user can update a role.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete role',
                'guard_name' => 'web',
                'description' => 'The user can delete a role.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search role',
                'guard_name' => 'web',
                'description' => 'The user can search a role.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage role',
                'guard_name' => 'web',
                'description' => 'The user can manage roles.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Permissions
            [
                'name' => 'viewAny permission',
                'guard_name' => 'web',
                'description' => 'The user can see permissions',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create permission',
                'guard_name' => 'web',
                'description' => 'The user can create a permission.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update permission',
                'guard_name' => 'web',
                'description' => 'The user can update a permission.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete permission',
                'guard_name' => 'web',
                'description' => 'The user can delete a permission.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'search permission',
                'guard_name' => 'web',
                'description' => 'The user can search a permission.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'manage permission',
                'guard_name' => 'web',
                'description' => 'The user can manage permissions.',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Settings
            [
                'name' => 'viewAny setting',
                'guard_name' => 'web',
                'description' => 'The user can see the settings.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'create setting',
                'guard_name' => 'web',
                'description' => 'The user can create a setting.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'update setting',
                'guard_name' => 'web',
                'description' => 'The user can update a setting.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'delete setting',
                'guard_name' => 'web',
                'description' => 'The user can delete a setting.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
            'name' => 'manage setting',
            'guard_name' => 'web',
            'description' => 'The user can manage settings.',
            'created_at' => $now,
            'updated_at' => $now,
        ]
        ];

        DB::table('permissions')->insert($permissions);
    }
}

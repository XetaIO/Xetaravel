<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Access Administration',
                'slug' => 'access.administration',
                'description' => 'The user can access to the administration.',
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Articles',
                'slug' => 'manage.articles',
                'description' => 'The user can manage the articles.',
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Roles',
                'slug' => 'manage.roles',
                'description' => 'The user can manage the roles.',
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Users',
                'slug' => 'manage.users',
                'description' => 'The user can manage the users.',
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Access Site',
                'slug' => 'access.site',
                'description' => 'The user can access to the site.',
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Show Banished',
                'slug' => 'show.banished',
                'description' => 'The user is banished.',
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('permissions')->insert($permissions);
    }
}

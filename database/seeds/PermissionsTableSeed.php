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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Articles',
                'slug' => 'manage.articles',
                'description' => 'The user can manage the articles.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Roles',
                'slug' => 'manage.roles',
                'description' => 'The user can manage the roles.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Users',
                'slug' => 'manage.users',
                'description' => 'The user can manage the users.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Access Site',
                'slug' => 'access.site',
                'description' => 'The user can access to the site.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Show bannished',
                'slug' => 'show.banished',
                'description' => 'The user is bannished.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('permissions')->insert($permissions);
    }
}

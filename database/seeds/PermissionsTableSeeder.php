<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'Access Administration',
            'slug' => 'access.administration',
            'description' => 'The user can access to the administration.',
        ]);
        Permission::create([
            'name' => 'Manage Articles',
            'slug' => 'manage.articles',
            'description' => 'The user can manage the articles.',
        ]);
        Permission::create([
            'name' => 'Access Site',
            'slug' => 'access.site',
            'description' => 'The user can access to the site.',
        ]);
        Permission::create([
            'name' => 'Show bannished',
            'slug' => 'show.banished',
            'description' => 'The user is bannished.',
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Administrator',
            'slug' => 'admin',
            'description' => '',
            'level' => 3,
        ]);
        Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => '',
            'level' => 2,
        ]);
        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => '',
            'level' => 1,
        ]);
        Role::create([
            'name' => 'Banished',
            'slug' => 'banished',
            'description' => '',
            'level' => 0,
        ]);
    }
}

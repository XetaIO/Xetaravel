<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class RolesTableSeed extends Seeder
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
            'css' => 'font-weight: bold; color: #ef3c3c;',
            'level' => 3,
        ]);
        Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'description' => '',
            'css' => 'font-weight: bold; color: #5ccc5c;',
            'level' => 2,
        ]);
        Role::create([
            'name' => 'User',
            'slug' => 'user',
            'description' => '',
            'css' => 'font-weight: bold;',
            'level' => 1,
        ]);
        Role::create([
            'name' => 'Banished',
            'slug' => 'banished',
            'description' => '',
            'css' => 'font-weight: bold; color: #843729;',
            'level' => 0,
        ]);
    }
}

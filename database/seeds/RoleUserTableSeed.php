<?php

use Illuminate\Database\Seeder;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

class RoleUserTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'Admin')->first();
        $user->attachRole(Role::where('slug', 'administrator')->first());

        $user = User::where('username', 'Editor')->first();
        $user->attachRole(Role::where('slug', 'editor')->first());

        $user = User::where('username', 'Member')->first();
        $user->attachRole(Role::where('slug', 'user')->first());

        $user = User::where('username', 'Banished')->first();
        $user->attachRole(Role::where('slug', 'banished')->first());
    }
}

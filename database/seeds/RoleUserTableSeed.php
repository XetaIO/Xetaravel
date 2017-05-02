<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;
use Xetaravel\Models\User;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'Admin')->first();
        $user->attachRole(Role::where('slug', 'admin')->first());
        
        $user = User::where('username', 'Editor')->first();
        $user->attachRole(Role::where('slug', 'editor')->first());

        $user = User::where('username', 'Member')->first();
        $user->attachRole(Role::where('slug', 'user')->first());

        $user = User::where('username', 'Banished')->first();
        $user->attachRole(Role::where('slug', 'banned')->first());
    }
}
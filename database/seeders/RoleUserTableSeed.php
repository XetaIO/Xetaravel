<?php
namespace Database\Seeders;

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
        $user->attachRole(Role::where('slug', 'developer')->first());

        $user = User::where('username', 'Moderator')->first();
        $user->attachRole(Role::where('slug', 'moderator')->first());

        $user = User::where('username', 'Member')->first();
        $user->attachRole(Role::where('slug', 'user')->first());

        $user = User::where('username', 'Banished')->first();
        $user->attachRole(Role::where('slug', 'banished')->first());
    }
}

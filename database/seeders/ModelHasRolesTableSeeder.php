<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Xetaravel\Models\User;

class ModelHasRolesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@xetaravel.io')->first();
        $user->assignRole('Developer');

        $user = User::where('email', 'moderator@xetaravel.io')->first();
        $user->assignRole('Moderator');

        $user = User::where('email', 'member@xetaravel.io')->first();
        $user->assignRole('User');

        $user = User::where('email', 'banished@xetaravel.io')->first();
        $user->assignRole('Banished');
    }
}

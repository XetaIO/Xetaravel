<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Xetaravel\Models\User;

class ModelHasPermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@xetaravel.io')->first();
        $user->givePermissionTo('bypass login');
    }
}

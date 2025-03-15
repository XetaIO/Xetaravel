<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();
        $roles = [
            [
                'name' => 'Developer',
                'description' => '',
                'color' => '#ef3c3c',
                'level' => 100,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Administrator',
                'description' => '',
                'color' => '#14e8e1',
                'level' => 90,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Moderator',
                'description' => '',
                'color' => '#5ccc5c',
                'level' => 80,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'User',
                'description' => '',
                'color' => '',
                'level' => 10,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Banished',
                'description' => '',
                'color' => '#843729',
                'level' => 0,
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}

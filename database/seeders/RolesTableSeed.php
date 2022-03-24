<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Developer',
                'slug' => 'developer',
                'description' => '',
                'css' => 'font-weight: bold; color: #ef3c3c;',
                'level' => 4,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Administrator',
                'slug' => 'administrator',
                'description' => '',
                'css' => 'font-weight: bold; color: #14e8e1;',
                'level' => 3,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Moderator',
                'slug' => 'moderator',
                'description' => '',
                'css' => 'font-weight: bold; color: #5ccc5c;',
                'level' => 2,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => '',
                'css' => 'font-weight: bold;',
                'level' => 1,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Banished',
                'slug' => 'banished',
                'description' => '',
                'css' => 'font-weight: bold; color: #843729;',
                'level' => 0,
                'is_deletable' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('roles')->insert($roles);
    }
}

<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            [
                'user_id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'Istrator',
                'facebook' => 'AdminFB',
                'twitter' => 'AdminTW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 2,
                'first_name' => 'Mode',
                'last_name' => 'Rator',
                'facebook' => 'ModeratorFB',
                'twitter' => 'ModeratorTW',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('accounts')->insert($accounts);
    }
}

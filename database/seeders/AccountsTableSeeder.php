<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();
        $accounts = [
            [
                'user_id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'Istrator',
                'facebook' => 'AdminFB',
                'twitter' => 'AdminTW',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 2,
                'first_name' => 'Mode',
                'last_name' => 'Rator',
                'facebook' => 'ModeratorFB',
                'twitter' => 'ModeratorTW',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('accounts')->insert($accounts);
    }
}

<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussUsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $comments = [
            [
                'user_id' => 1,
                'conversation_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'conversation_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('discuss_users')->insert($comments);
    }
}

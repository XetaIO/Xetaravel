<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersExperiencesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $xp = [
            [
                'user_id' => 1,
                'amount' => 90,
                'obtainable_type' => 'Xetaravel\\Models\\DiscussConversation',
                'obtainable_id' => 1,
                'event_type' => 'Xetaravel\\Events\\Users\\Xp\\NewThreadEvent',
                'data' => '{"id":1}',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 2,
                'amount' => 75,
                'obtainable_type' => 'Xetaravel\\Models\\DiscussConversation',
                'obtainable_id' => 1,
                'event_type' => 'Xetaravel\\Events\\Users\\Xp\\NewPostEvent',
                'data' => '{"id":2}',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('users_experiences')->insert($xp);
    }
}

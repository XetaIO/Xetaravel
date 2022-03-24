<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExperiencesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $experiences = [
            [
                'user_id' => 1,
                'amount' => 90,
                'obtainable_type' => 'Xetaravel\\Models\\DiscussConversation',
                'obtainable_id' => 1,
                'event_type' => 'Xetaravel\\Events\\Experiences\\ConversationWasCreatedEvent',
                'data' => '[]',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'user_id' => 2,
                'amount' => 75,
                'obtainable_type' => 'Xetaravel\\Models\\DiscussPost',
                'obtainable_id' => 2,
                'event_type' => 'Xetaravel\\Events\\Experiences\\PostWasCreatedEvent',
                'data' => '[]',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('experiences')->insert($experiences);
    }
}

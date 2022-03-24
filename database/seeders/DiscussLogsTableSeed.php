<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussLogsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->addMinutes(2);

        $logs = [
            [
                'user_id' => 1,
                'loggable_id' => 1,
                'loggable_type' => 'Xetaravel\\Models\\DiscussConversation',
                'event_type' => 'Xetaravel\\Events\\Discuss\\CategoryWasChangedEvent',
                'data' => '{"new":1,"old":2}',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('discuss_logs')->insert($logs);
    }
}

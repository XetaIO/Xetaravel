<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussLogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
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

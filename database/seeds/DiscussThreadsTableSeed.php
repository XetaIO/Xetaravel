<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussThreadsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $threads = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'This is an announcement.',
                'slug' => 'this-is-an-announcement',
                'content' => '**Lorem ipsum** dolor sit amet, consectetuer *adipiscing* elit, sed diam nonummy nibh euismod `tincidunt ut laoreet` dolore magna aliquam erat volutpat.',
                'comment_count' => 1,
                'is_locked' => true,
                'is_pinned' => false,
                'is_solved' => false,
                'is_edited' => false,
                'solved_comment_id' => null,
                'last_comment_id' => null,
                'edited_user_id' => null,
                'edited_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('discuss_threads')->insert($threads);
    }
}

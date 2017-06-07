<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussCommentsTableSeed extends Seeder
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
                'thread_id' => 1,
                'content' => '**Lorem ipsum** dolor sit amet, consectetuer *adipiscing* elit, sed diam nonummy nibh euismod `tincidunt ut laoreet` dolore magna aliquam erat volutpat.',
                'is_edited' => false,
                'edited_user_id' => null,
                'edited_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('discuss_comments')->insert($comments);

        // Update the foreign key related to comments.
        DB::table('discuss_threads')
            ->where('id', 1)
            ->update(['last_comment_id' => 1]);
    }
}

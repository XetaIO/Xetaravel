<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussPostsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $posts = [
            [
                'user_id' => 1,
                'conversation_id' => 1,
                'content' => '**Lorem ipsum** dolor sit amet, consectetuer *adipiscing* elit, sed diam nonummy nibh euismod `tincidunt ut laoreet` dolore magna aliquam erat volutpat.',
                'is_solved' => false,
                'edit_count' => 1,
                'is_edited' => true,
                'edited_user_id' => 1,
                'edited_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'conversation_id' => 1,
                'content' => '**Lorem ipsum** dolor sit amet, consectetuer *adipiscing* elit, sed diam nonummy nibh euismod `tincidunt ut laoreet` dolore magna aliquam erat volutpat.',
                'is_solved' => false,
                'edit_count' => 0,
                'is_edited' => false,
                'edited_user_id' => null,
                'edited_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('discuss_posts')->insert($posts);

        // Update the foreign key related to posts.
        DB::table('discuss_conversations')
            ->where('id', 1)
            ->update([
                'first_post_id' => 1,
                'last_post_id' => 2
            ]);
    }
}

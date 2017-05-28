<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            [
                'user_id' => 2,
                'article_id' => 1,
                'content' => 'Lorem **ipsum dolor sit amet**, consectetuer adipiscing elit, sed diam nonummy nibh *euismod tincidunt* ut laoreet dolore `magna aliquam` erat volutpat.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('comments')->insert($comments);
    }
}

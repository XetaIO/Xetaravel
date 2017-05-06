<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Xetaravel\Models\Comment;

class CommentsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::create([
            'user_id' => 2,
            'article_id' => 1,
            'content' => '<p>Lorem i<strong>psum dolor sit amet,</strong> consectetuer adipiscing elit, sed diam nonummy nibh <u>euismod tincidunt </u>ut laoreet dolore <em>magna aliquam </em>erat volutpat.</p>',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
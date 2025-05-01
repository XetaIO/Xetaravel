<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();
        $comments = [
            [
                'user_id' => 2,
                'blog_article_id' => 1,
                'content' => 'Lorem **ipsum dolor sit amet**, consectetuer adipiscing elit, sed diam nonummy nibh *euismod tincidunt* ut laoreet dolore `magna aliquam` erat volutpat.',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('blog_comments')->insert($comments);
    }
}

<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscussCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        $categories = [
            [
                'title' => 'Xetaravel',
                'slug' => 'xetaravel',
                'description' => 'All threads related to the development and announcements of Xetaravel.',
                'color' => '#F4645F',
                'icon' => 'fas-bullhorn',
                'conversation_count' => 1,
                'last_conversation_id' => null,
                'is_locked' => true,
                'level' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Development',
                'slug' => 'development',
                'description' => 'All threads related to the development in general.',
                'color' => '#48BF83',
                'icon' => 'fas-code',
                'conversation_count' => 0,
                'last_conversation_id' => null,
                'is_locked' => false,
                'level' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Feedback',
                'slug' => 'feedback',
                'description' => 'For discussing about Xetaravel features and design.',
                'color' => '#9354CA',
                'icon' => 'fas-comment-dots',
                'conversation_count' => 0,
                'last_conversation_id' => null,
                'is_locked' => false,
                'level' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'General',
                'slug' => 'general',
                'description' => 'Discussions about everything that don\'t fit into any other categories.',
                'color' => '#00B1B3',
                'icon' => 'fas-toolbox',
                'conversation_count' => 0,
                'last_conversation_id' => null,
                'is_locked' => false,
                'level' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('discuss_categories')->insert($categories);
    }
}

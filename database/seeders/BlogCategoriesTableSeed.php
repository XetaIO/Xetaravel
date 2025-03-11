<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategoriesTableSeed extends Seeder
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
                'title' => 'Laravel',
                'description' => 'All articles related to Laravel.',
                'article_count' => 1,
                'slug' => 'laravel',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'title' => 'Xetaravel',
                'description' => 'All articles related to Xetaravel.',
                'article_count' => 0,
                'slug' => 'xetaravel',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}

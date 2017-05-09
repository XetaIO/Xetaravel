<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'title' => 'Laravel',
                'description' => 'All articles related to Laravel.',
                'article_count' => 1,
                'slug' => 'laravel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Xetaravel',
                'description' => 'All articles related to Xetaravel.',
                'article_count' => 0,
                'slug' => 'xetaravel',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('categories')->insert($categories);
    }
}

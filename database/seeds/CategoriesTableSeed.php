<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Xetaravel\Models\Category;

class CategoriesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'title' => 'Laravel',
            'description' => 'All articles related to Laravel.',
            'article_count' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        Category::create([
            'title' => 'Xetaravel',
            'description' => 'All articles related to Xetaravel.',
            'article_count' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Users Table
         */
        DB::table('users')->insert([
            [
                'username' => 'Xeta',
                'email' => 'emeric@xeta.io',
                'password' => bcrypt('123456789'),
                'slug' => 'xeta',
                'article_count' => 2,
                'is_admin' => 1,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'username' => 'Test',
                'email' => 'test@xeta.io',
                'password' => bcrypt('123456789'),
                'slug' => 'test',
                'article_count' => 0,
                'is_admin' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);

        /**
         * Categories Table
         */
        DB::table('categories')->insert([
            'title' => 'Laravel',
            'slug' => 'laravel',
            'description' => 'All articles related to Laravel.',
            'article_count' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        /**
         * Articles Table
         */
        DB::table('articles')->insert([
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Article 1',
                'slug' => 'article-1',
                'content' => 'Sint officia est numquam et ea fuga.',
                'is_display' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Article 2',
                'slug' => 'article-2',
                'content' => 'Sint officia est numquam et ea fuga.',
                'is_display' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}

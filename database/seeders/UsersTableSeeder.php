<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Xetaravel\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        $users = [
            [
                'username' => 'Admin',
                'email' => 'admin@xetaravel.io',
                'password' => bcrypt('admin'),
                'slug' => 'admin',
                'blog_article_count' => 1,
                'blog_comment_count' => 0,
                'discuss_conversation_count' => 1,
                'discuss_post_count' => 1,
                'experiences_total' => 90,
                'rubies_total' => 50,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login_date' => $now,
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'Moderator',
                'email' => 'moderator@xetaravel.io',
                'password' => bcrypt('moderator'),
                'slug' => 'moderator',
                'blog_article_count' => 0,
                'blog_comment_count' => 1,
                'discuss_conversation_count' => 0,
                'discuss_post_count' => 1,
                'experiences_total' => 75,
                'rubies_total' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login_date' => $now,
                'email_verified_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'Member',
                'email' => 'member@xetaravel.io',
                'password' => bcrypt('member'),
                'slug' => 'member',
                'blog_article_count' => 0,
                'blog_comment_count' => 0,
                'discuss_conversation_count' => 0,
                'discuss_post_count' => 0,
                'experiences_total' => 0,
                'rubies_total' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login_date' => $now,
                'email_verified_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'username' => 'Banished',
                'email' => 'banished@xetaravel.io',
                'password' => bcrypt('banished'),
                'slug' => 'banished',
                'blog_article_count' => 0,
                'blog_comment_count' => 0,
                'discuss_conversation_count' => 0,
                'discuss_post_count' => 0,
                'experiences_total' => 0,
                'rubies_total' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login_date' => $now,
                'email_verified_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        DB::table('users')->insert($users);

        // Update avatars
        foreach ($users as $user) {
            $model = User::where('username', $user['username'])->first();
            $model->addMedia(public_path('images/avatar.png'))
                ->preservingOriginal()
                ->setName(substr(md5($user['username']), 0, 10))
                ->setFileName(substr(md5($user['username']), 0, 10) . '.png')
                ->withCustomProperties(['primaryColor' => '#B4AEA4'])
                ->toMediaCollection('avatar');
        }
    }
}

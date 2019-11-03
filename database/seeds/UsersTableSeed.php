<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'Admin',
                'email' => 'admin@xeta.io',
                'password' => bcrypt('admin'),
                'slug' => 'admin',
                'article_count' => 1,
                'comment_count' => 0,
                'discuss_conversation_count' => 1,
                'discuss_post_count' => 1,
                'experiences_total' => 90,
                'rubies_total' => 50,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Editor',
                'email' => 'editor@xeta.io',
                'password' => bcrypt('editor'),
                'slug' => 'editor',
                'article_count' => 0,
                'comment_count' => 1,
                'discuss_conversation_count' => 0,
                'discuss_post_count' => 1,
                'experiences_total' => 75,
                'rubies_total' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Member',
                'email' => 'member@xeta.io',
                'password' => bcrypt('member'),
                'slug' => 'member',
                'article_count' => 0,
                'comment_count' => 0,
                'discuss_conversation_count' => 0,
                'discuss_post_count' => 0,
                'experiences_total' => 0,
                'rubies_total' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'username' => 'Banished',
                'email' => 'banished@xeta.io',
                'password' => bcrypt('banished'),
                'slug' => 'banished',
                'article_count' => 0,
                'comment_count' => 0,
                'discuss_conversation_count' => 0,
                'discuss_post_count' => 0,
                'experiences_total' => 0,
                'rubies_total' => 0,
                'register_ip' => '127.0.0.1',
                'last_login_ip' => '127.0.0.1',
                'last_login' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        DB::table('users')->insert($users);

        // Update avatars
        foreach ($users as $user) {
            $model = \Xetaravel\Models\User::where('username', $user['username'])->first();
            $model->addMedia(resource_path('assets/images/avatar.png'))
                ->preservingOriginal()
                ->setName(substr(md5($user['username']), 0, 10))
                ->setFileName(substr(md5($user['username']), 0, 10) . '.png')
                ->withCustomProperties(['primaryColor' => '#B4AEA4'])
                ->toMediaCollection('avatar');
        }
    }
}

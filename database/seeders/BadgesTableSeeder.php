<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = Carbon::now();

        $badges = [
            // Leaderboard
            [
                'name' => 'Pillar of the Community',
                'slug' => 'topleaderboard',
                'description' => 'Unlocked when your experience points are in the top 3 of all Xetaravel members.',
                'icon' => 'fas fa-medal',
                'color' => '#f7a925',
                'type' => 'topLeaderboard',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Inscription
            [
                'name' => 'Registered for 1 year!',
                'slug' => 'newregister1',
                'description' => 'Earned when you have been registered on Xetaravel for 1 year.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#2ec5ff',
                'type' => 'onNewRegister',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Young teenager !',
                'slug' => 'newregister2',
                'description' => 'Earned when you have been registered on Xetaravel for 2 years.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#2eff51',
                'type' => 'onNewRegister',
                'rule' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'You are getting old!',
                'slug' => 'newregister3',
                'description' => 'Earned when you have been registered on Xetaravel for 3 years.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#dfff2e',
                'type' => 'onNewRegister',
                'rule' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '3rd age club!',
                'slug' => 'newregister5',
                'description' => 'Earned when you have been registered on Xetaravel for 5 years.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#ffbf2e',
                'type' => 'onNewRegister',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'This is the retirement home!',
                'slug' => 'newregister7',
                'description' => 'Earned when you have been registered on Xetaravel for 7 years.',
                'icon' => 'fas fa-sign-in-alt',
                'color' => '#ff412e',
                'type' => 'onNewRegister',
                'rule' => 7,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Posts
            [
                'name' => 'Welcome in the community !',
                'slug' => 'newpost1',
                'description' => 'Obtained after your first message on the Xetaravel discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#2ec5ff',
                'type' => 'onNewPost',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Talkative!',
                'slug' => 'newpost10',
                'description' => 'Obtained once you have posted 10 replies to the discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#2effcf',
                'type' => 'onNewPost',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real chatterbox !',
                'slug' => 'newpost50',
                'description' => 'Obtained once you have posted 50 replies to the discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#2eff51',
                'type' => 'onNewPost',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'You don\'t stop yelling!',
                'slug' => 'newpost100',
                'description' => 'Obtained once you have posted 100 replies to the discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#dfff2e',
                'type' => 'onNewPost',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real spammer!',
                'slug' => 'newpost500',
                'description' => 'Obtained once you have posted 500 replies to the discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#ffbf2e',
                'type' => 'onNewPost',
                'rule' => 500,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Time to change your keyboard!',
                'slug' => 'newpost1000',
                'description' => 'Obtained once you have posted 1000 replies to the discuss.',
                'icon' => 'far fa-comment-dots',
                'color' => '#ff412e',
                'type' => 'onNewPost',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Posts Résolus
            [
                'name' => 'You helped a member!',
                'slug' => 'postsolved1',
                'description' => 'Obtained once you receive your first « Resolved Response » on the Xetaravel discuss.',
                'icon' => 'fas fa-check',
                'color' => '#2ec5ff',
                'type' => 'onPostSolved',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'You are really smart!',
                'slug' => 'postsolved10',
                'description' => 'Obtained once you have received 10 or more « Resolved Response » on the discuss.',
                'icon' => 'fas fa-check',
                'color' => '#2eff51',
                'type' => 'onPostSolved',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real tutor!',
                'slug' => 'postsolved20',
                'description' => 'Obtained once you have received 20 or more « Resolved Response » on the discuss.',
                'icon' => 'fas fa-check',
                'color' => '#dfff2e',
                'type' => 'onPostSolved',
                'rule' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'An encyclopedia !',
                'slug' => 'postsolved50',
                'description' => 'Obtained once you have received 50 or more « Resolved Response » on the discuss.',
                'icon' => 'fas fa-check',
                'color' => '#ff412e',
                'type' => 'onPostSolved',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Expériences
            [
                'name' => 'The first hundred!',
                'slug' => 'newexperience100',
                'description' => 'Obtained once you have earned your first 100 experience points.',
                'icon' => 'fas fa-star',
                'color' => '#2ec5ff',
                'type' => 'onNewExperience',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'The first thousand!',
                'slug' => 'newexperience1000',
                'description' => 'Obtained once you have earned your first 1000 experience points.',
                'icon' => 'fas fa-star',
                'color' => '#2eff51',
                'type' => 'onNewExperience',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real soldier!',
                'slug' => 'newexperience10000',
                'description' => 'Obtained once you have earned your first 10000 experience points.',
                'icon' => 'fas fa-star',
                'color' => '#dfff2e',
                'type' => 'onNewExperience',
                'rule' => 10000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A Xetaravel veteran!',
                'slug' => 'newexperience100000',
                'description' => 'Obtained once you have earned your first 100000 experience points.',
                'icon' => 'fas fa-star',
                'color' => '#ffbf2e',
                'type' => 'onNewExperience',
                'rule' => 100000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'The million!',
                'slug' => 'newexperience1000000',
                'description' => 'Obtained once your experience points exceed one million.',
                'icon' => 'fas fa-star',
                'color' => '#ff412e',
                'type' => 'onNewExperience',
                'rule' => 1000000,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Rubies
            [
                'name' => 'It shines !',
                'slug' => 'newrubies50',
                'description' => 'Obtained once you have earned your first 50 rubies.',
                'icon' => 'fa fa-diamond',
                'color' => '#2ec5ff',
                'type' => 'onNewRuby',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'As if it rained !',
                'slug' => 'newrubies100',
                'description' => 'Obtained once your rubies reach 100.',
                'icon' => 'fa fa-diamond',
                'color' => '#2eff51',
                'type' => 'onNewRuby',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real miner!',
                'slug' => 'newrubies500',
                'description' => 'Obtained once your rubies reach 500.',
                'icon' => 'fa fa-diamond',
                'color' => '#dfff2e',
                'type' => 'onNewRuby',
                'rule' => 500,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real jeweller!',
                'slug' => 'newrubies1000',
                'description' => 'Obtained once your rubies reach 1000.',
                'icon' => 'fa fa-diamond',
                'color' => '#ff412e',
                'type' => 'onNewRuby',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('badges')->insert($badges);
    }
}

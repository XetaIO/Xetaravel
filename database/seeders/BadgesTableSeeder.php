<?php

declare(strict_types=1);

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
                'description' => 'Unlocked when your experience points are in the top 3 of all Xetaravel members.',
                'icon' => 'fas-medal',
                'color' => '#f7a925',
                'type' => 'topLeaderboard',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Inscription
            [
                'name' => 'Registered for 1 year!',
                'description' => 'Earned when you have been registered on Xetaravel for 1 year.',
                'icon' => 'fas-sign-in-alt',
                'color' => '#2ec5ff',
                'type' => 'onRegister',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Young teenager !',
                'description' => 'Earned when you have been registered on Xetaravel for 2 years.',
                'icon' => 'fas-sign-in-alt',
                'color' => '#2eff51',
                'type' => 'onRegister',
                'rule' => 2,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'You are getting old!',
                'description' => 'Earned when you have been registered on Xetaravel for 3 years.',
                'icon' => 'fas-sign-in-alt',
                'color' => '#dfff2e',
                'type' => 'onRegister',
                'rule' => 3,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => '3rd age club!',
                'description' => 'Earned when you have been registered on Xetaravel for 5 years.',
                'icon' => 'fas-sign-in-alt',
                'color' => '#ffbf2e',
                'type' => 'onRegister',
                'rule' => 5,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'This is the retirement home!',
                'description' => 'Earned when you have been registered on Xetaravel for 7 years.',
                'icon' => 'fas-sign-in-alt',
                'color' => '#ff412e',
                'type' => 'onRegister',
                'rule' => 7,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Posts
            [
                'name' => 'Welcome in the community !',
                'description' => 'Obtained after your first message on the Xetaravel discuss.',
                'icon' => 'far-comment-dots',
                'color' => '#2ec5ff',
                'type' => 'onPost',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Talkative!',
                'description' => 'Obtained once you have posted 10 replies to the discuss.',
                'icon' => 'far-comment-dots',
                'color' => '#2effcf',
                'type' => 'onPost',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real chatterbox !',
                'description' => 'Obtained once you have posted 50 replies to the discuss.',
                'icon' => 'far-comment-dots',
                'color' => '#2eff51',
                'type' => 'onPost',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'You don\'t stop yelling!',
                'description' => 'Obtained once you have posted 100 replies to the discuss.',
                'icon' => 'far-comment-dots',
                'color' => '#dfff2e',
                'type' => 'onPost',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real spammer!',
                'description' => 'Obtained once you have posted 500 replies to the discuss.',
                'icon' => 'far-comment-dots',
                'color' => '#ffbf2e',
                'type' => 'onPost',
                'rule' => 500,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'Time to change your keyboard!',
                'description' => 'Obtained once you have posted 1000 replies to the discuss.',
                'icon' => 'far-comment-dots',
                'color' => '#ff412e',
                'type' => 'onPost',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],

            // Solved Posts
            [
                'name' => 'You helped a member!',
                'description' => 'Obtained once you receive your first « Resolved Response » on the Xetaravel discuss.',
                'icon' => 'fas-check',
                'color' => '#2ec5ff',
                'type' => 'onPostSolved',
                'rule' => 1,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'You are really smart!',
                'description' => 'Obtained once you have received 10 or more « Resolved Response » on the discuss.',
                'icon' => 'fas-check',
                'color' => '#2eff51',
                'type' => 'onPostSolved',
                'rule' => 10,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real tutor!',
                'description' => 'Obtained once you have received 20 or more « Resolved Response » on the discuss.',
                'icon' => 'fas-check',
                'color' => '#dfff2e',
                'type' => 'onPostSolved',
                'rule' => 20,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'An encyclopedia !',
                'description' => 'Obtained once you have received 50 or more « Resolved Response » on the discuss.',
                'icon' => 'fas-check',
                'color' => '#ff412e',
                'type' => 'onPostSolved',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Experiences
            [
                'name' => 'The first hundred!',
                'description' => 'Obtained once you have earned your first 100 experience points.',
                'icon' => 'fas-star',
                'color' => '#2ec5ff',
                'type' => 'onExperience',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'The first thousand!',
                'description' => 'Obtained once you have earned your first 1000 experience points.',
                'icon' => 'fas-star',
                'color' => '#2eff51',
                'type' => 'onExperience',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real soldier!',
                'description' => 'Obtained once you have earned your first 10000 experience points.',
                'icon' => 'fas-star',
                'color' => '#dfff2e',
                'type' => 'onExperience',
                'rule' => 10000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A Xetaravel veteran!',
                'description' => 'Obtained once you have earned your first 100000 experience points.',
                'icon' => 'fas-star',
                'color' => '#ffbf2e',
                'type' => 'onExperience',
                'rule' => 100000,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'The million!',
                'description' => 'Obtained once your experience points exceed one million.',
                'icon' => 'fas-star',
                'color' => '#ff412e',
                'type' => 'onExperience',
                'rule' => 1000000,
                'created_at' => $now,
                'updated_at' => $now
            ],

            //  Rubies
            [
                'name' => 'It shines !',
                'description' => 'Obtained once you have earned your first 50 rubies.',
                'icon' => 'far-gem',
                'color' => '#2ec5ff',
                'type' => 'onRuby',
                'rule' => 50,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'As if it rained !',
                'description' => 'Obtained once your rubies reach 100.',
                'icon' => 'far-gem',
                'color' => '#2eff51',
                'type' => 'onRuby',
                'rule' => 100,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real miner!',
                'description' => 'Obtained once your rubies reach 500.',
                'icon' => 'far-gem',
                'color' => '#dfff2e',
                'type' => 'onRuby',
                'rule' => 500,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'A real jeweller!',
                'description' => 'Obtained once your rubies reach 1000.',
                'icon' => 'far-gem',
                'color' => '#ff412e',
                'type' => 'onRuby',
                'rule' => 1000,
                'created_at' => $now,
                'updated_at' => $now
            ],
        ];

        DB::table('badges')->insert($badges);
    }
}

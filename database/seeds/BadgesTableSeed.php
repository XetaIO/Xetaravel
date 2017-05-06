<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BadgesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $badges = [
            [
                'name' => 'First Comment',
                'image' => 'images/badges/comments-1.png',
                'type' => 'onNewComment',
                'rule' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => '10 Comments',
                'image' => 'images/badges/comments-10.png',
                'type' => 'onNewComment',
                'rule' => '10',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Inscrit depuis 1 an',
                'image' => 'images/badges/registration-1.png',
                'type' => 'onNewRegister',
                'rule' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        DB::table('badges')->insert($badges);
    }
}
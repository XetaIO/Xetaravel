<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        $settings = [
            [
                'name' => 'user.login.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Active/Désactive le système et la page de connexion.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.register.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Active/Désactive le système et la page d\'inscription',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.rewards.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Active/Désactive le système et la page de rewards.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.email.verification.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Active/Désactive le système de vérification des emails.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'discuss.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Active/Désactive le système Discuss.',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}

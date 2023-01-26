<?php
namespace Database\Seeders;

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
                'description' => 'Enable/Disable the login system.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.register.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Enable/Disable the register system.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'user.email.verification.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Enable/Disable the email verification system.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'discuss.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Enable/Disable the Discuss system.',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'shop.enabled',
                'value_int' => null,
                'value_str' => null,
                'value_bool' => true,
                'description' => 'Enable/Disable the Shop system.',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ];

        DB::table('settings')->insert($settings);
    }
}

<?php
namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Filesystem\Filesystem;
use Xetaravel\Models\Setting;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();

        Hash::driver('bcrypt')->setRounds(4);

        config(['medialibrary.defaultFilesystem' => 'tests']);

        return $app;
    }

    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh');
        Artisan::call('db:seed', ['--class' => 'TestingDatabaseSeeder']);

        // Set the all Settings in the config array.
        $settings = Setting::all([
            'name',
            'value_int',
            'value_str',
            'value_bool',
        ])
        ->keyBy('name') // key every setting by its name
        ->transform(function ($setting) {
            return $setting->value; // return only the value
        })
        ->toArray();

        $array = [];
        // Convert the `dot` syntax to array.
        foreach ($settings as $setting => $value) {
            data_set($array, $setting, $value);
        }
        config(['settings' => $array]);
    }

    /**
     * Triggered after each test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        $temp = public_path() . '/tests/storage';

        $filesystem = new Filesystem();
        $filesystem->remove($temp);
    }
}

<?php
namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use Symfony\Component\Filesystem\Filesystem;

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
        
        config(['medialibrary.defaultFilesystem' => 'tests']);
        
        return $app;
    }
    
    /**
     * Triggered before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'TestingDatabaseSeeder']);
    }

    public function tearDown()
    {
        $temp = public_path() . '/tests/storage';

        $filesystem = new Filesystem();
        $filesystem->remove($temp);
    }
}

<?php

declare(strict_types=1);

namespace Xetaravel\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Xetaravel\Extensions\CustomDatabaseSessionHandler;
use Xetaravel\Services\DeviceDetectorService;

class SessionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Session::extend('custom_database', function ($app) {
            $connection = DB::connection(config('session.connection'));

            $table = config('session.table');

            $lifetime = config('session.lifetime');

            return new CustomDatabaseSessionHandler(
                $connection,
                $table,
                $lifetime,
                $app,
                $app->make(DeviceDetectorService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

}

<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Xetaravel\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // View
        View::addNamespace('Admin', base_path() . '/resources/views/Admin');
        View::addNamespace('Blog', base_path() . '/resources/views/Blog');
        View::addNamespace('Auth', base_path() . '/resources/views/Auth');
        View::addNamespace('Discuss', base_path() . '/resources/views/Discuss');

        // Pagination
        Paginator::defaultView('vendor.pagination.tailwind');

        // Blade
        Blade::directive('auth', function () {
            return "<?php if (Auth::check()): ?>";
        });
        Blade::directive('endauth', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('notauth', function () {
            return "<?php if (!Auth::check()): ?>";
        });
        Blade::directive('endnotauth', function () {
            return "<?php endif; ?>";
        });

        if (App::environment() !== 'testing' && Schema::hasTable('settings')) {
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

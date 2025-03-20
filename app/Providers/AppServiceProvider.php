<?php

declare(strict_types=1);

namespace Xetaravel\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Xetaravel\Settings\Settings;
use Xetaravel\View\Composers\Blog\SidebarComposer as BlogSidebarComposer;
use Xetaravel\View\Composers\Discuss\SidebarComposer as DiscussSidebarComposer;
use Xetaravel\View\Composers\NotificationsComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Models
        Model::preventLazyLoading();
        Model::preventAccessingMissingAttributes();

        // Routes
        Route::pattern('id', '[0-9]+');

        // Builder
        Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        });

        // View
        View::addNamespace('Admin', base_path() . '/resources/views/Admin');
        View::addNamespace('Blog', base_path() . '/resources/views/Blog');
        View::addNamespace('Auth', base_path() . '/resources/views/Auth');
        View::addNamespace('Discuss', base_path() . '/resources/views/Discuss');
        View::composer('partials._notifications', NotificationsComposer::class);
        View::composer('Blog::partials._sidebar', BlogSidebarComposer::class);
        View::composer('Discuss::partials._sidebar', DiscussSidebarComposer::class);

        // Pagination
        //Paginator::defaultView('vendor.pagination.tailwind');

        // Set default password rule for the application.
        Password::defaults(function () {
            $rule = Password::min(8);

            return App::isProduction() || App::isLocal()
                ? $rule->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                : $rule;
        });

        // ResetPassword
        ResetPassword::createUrlUsing(function ($notifiable, $token) {
            // Add `auth.` to the route to respect the namespace.
            return url(route('auth.password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));
        });

        /**
         * All credits from this blade directive goes to Konrad Kalemba.
         * Just copied and modified for my very specifc use case.
         *
         * https://github.com/konradkalemba/blade-components-scoped-slots
         */
        Blade::directive('scope', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);

            [$name, $functionArguments] = $directiveArguments;

            /**
             *  Slot names can`t contains dot , eg: `user.city`.
             *  So we convert `user.city` to `user___city`
             *
             *  Later, on component you must replace it back.
             */
            $name = str_replace('.', '___', $name);

            return "<?php \$__env->slot({$name}, function({$functionArguments}) use (\$__env) { ?>";
        });

        Blade::directive('endscope', function () {
            return '<?php }); ?>';
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the Settings class
        $this->app->singleton(Settings::class, function (Application $app) {
            return new Settings($app['cache.store']);
        });
    }
}

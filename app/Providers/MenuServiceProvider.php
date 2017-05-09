<?php
namespace Xetaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Menu\Laravel\MenuFacade as Menu;
use Spatie\Menu\Laravel\Link;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Menu::macro('userProfile', function () {
            return Menu::new()
                ->addClass('nav nav-menu flex-column')
                ->setAttribute('role', 'navigation')
                ->add(
                    Link::toRoute('users.account.index', '<i class="fa fa-user"></i> Account')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.notification.index', '<i class="fa fa-bell-o"></i> Notifications')
                        ->addClass('nav-link')
                )
                ->add(
                    Link::toRoute('users.user.settings', '<i class="fa fa-cogs"></i> Settings')
                        ->addClass('nav-link')
                )
                ->setActiveFromRequest();
        });
    }
}

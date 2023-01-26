<?php
namespace Xetaravel\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Xetaravel\View\Composers\Blog\SidebarComposer;
use Xetaravel\View\Composers\Discuss\SidebarComposer as DiscussSidebarComposer;
use Xetaravel\View\Composers\Shop\SidebarComposer as ShopSidebarComposer;
use Xetaravel\View\Composers\NotificationsComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::composer('partials._notifications', NotificationsComposer::class);
        View::composer('Blog::partials._sidebar', SidebarComposer::class);
        View::composer('Discuss::partials._sidebar', DiscussSidebarComposer::class);
        View::composer('Shop::partials._sidebar', ShopSidebarComposer::class);
    }
}

<?php
namespace Xetaravel\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Xetaravel\Models\Repositories\UserRepository;

class NotificationsServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('partials._notifications', function ($view) {
            $notifications = UserRepository::notificationsData(Auth::id());

            $view->with([
                'notifications' => $notifications['notifications'],
                'hasUnreadNotifications' => $notifications['hasUnreadNotifications'],
                'unreadNotificationsCount' => $notifications['unreadNotificationsCount']
            ]);
        });
    }
}

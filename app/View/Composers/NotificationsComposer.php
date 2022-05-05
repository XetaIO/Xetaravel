<?php
namespace Xetaravel\View\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaravel\Models\Repositories\UserRepository;

class NotificationsComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $notifications = UserRepository::notificationsData(Auth::id());

        $view->with([
            'notifications' => $notifications['notifications'],
            'hasUnreadNotifications' => $notifications['hasUnreadNotifications'],
            'unreadNotificationsCount' => $notifications['unreadNotificationsCount']
        ]);
    }
}

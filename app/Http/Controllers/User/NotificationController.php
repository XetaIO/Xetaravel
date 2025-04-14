<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Newsletter;
use Xetaravel\Models\User;

class NotificationController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg class="inline w-5 h-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c10 0 18.8-4.9 24.2-12.5l-99.2-99.2c-14.9-14.9-23.3-35.1-23.3-56.1l0-33c-15.9-4.7-32.8-7.2-50.3-7.2l-91.4 0zM384 224c-17.7 0-32 14.3-32 32l0 82.7c0 17 6.7 33.3 18.7 45.3L478.1 491.3c18.7 18.7 49.1 18.7 67.9 0l73.4-73.4c18.7-18.7 18.7-49.1 0-67.9L512 242.7c-12-12-28.3-18.7-45.3-18.7L384 224zm24 80a24 24 0 1 1 48 0 24 24 0 1 1 -48 0z"></path></svg>
                          Notifications',
            route('user.notification.index')
        );
    }

    /**
     * Show the notifications & newsletter.
     *
     * @return View
     */
    public function index(): View
    {
        $user = User::find(Auth::id());

        $notifications = $user->notifications()
            ->paginate(config('xetaravel.pagination.notification.notification_per_page'));
        $hasUnreadNotifications = $user->unreadNotifications->isNotEmpty();

        $breadcrumbs = $this->breadcrumbs;

        $newsletter = Newsletter::where('email', $user->email)->first();

        return view(
            'notification.index',
            compact('user', 'breadcrumbs', 'notifications', 'hasUnreadNotifications', 'newsletter')
        );
    }

    /**
     * Delete a notification by its ID.
     *
     * @param string $slug The notification ID.
     *
     * @return RedirectResponse
     */
    public function delete(string $slug)
    {
        $user = Auth::user();
        $notification = $user->notifications()
            ->where('id', $slug)
            ->first();

        if ($notification) {
            $notification->delete();

            return back()
                ->success('The notification has been deleted.');
        }

        return back()
            ->error('An error occurred while deleting the notification.');
    }
}

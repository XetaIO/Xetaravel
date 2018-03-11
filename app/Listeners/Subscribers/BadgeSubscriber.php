<?php
namespace Xetaravel\Listeners\Subscribers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Xetaravel\Events\RegisterEvent;
use Xetaravel\Events\CommentEvent;
use Xetaravel\Models\Badge;
use Xetaravel\Models\User;
use Xetaravel\Notifications\BadgeNotification;

class BadgeSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     *
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            'Xetaravel\Events\RegisterEvent',
            'Xetaravel\Listeners\Subscribers\BadgeSubscriber@onNewRegister'
        );

        $events->listen(
            'Xetaravel\Events\CommentEvent',
            'Xetaravel\Listeners\Subscribers\BadgeSubscriber@onNewComment'
        );
    }

    /**
     * Listener related to the comment badge.
     *
     * @param \Xetaravel\Events\CommentEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewComment(CommentEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewComment')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            return $badge->rule <= $user->comment_count;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the register badge.
     *
     * @param \Xetaravel\Events\RegisterEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewRegister(RegisterEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewRegister')->get();

        $today = new Carbon();
        $diff = $today->diff($user->created_at)->y;

        $collection = $badges->filter(function ($badge) use ($diff) {
            return $badge->rule <= $diff;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Send a notification for each new badge unlocked.
     *
     * @param array $result The result of the synchronization.
     * @param \Illuminate\Database\Eloquent\Collection $badges The badges collection related to the listener.
     * @param \Xetaravel\Models\User $user The user to notify.
     *
     * @return bool
     */
    protected function sendNotifications(array $result, Collection $badges, User $user): bool
    {
        if (empty($result['attached'])) {
            return true;
        }

        $sendNotification = function ($badgeId, $key, $badges) use ($user) {
            $badgeCollection = $badges->filter(function ($badge) use ($badgeId) {
                return $badge->id == $badgeId;
            })->first();

            $user->notify(new BadgeNotification($badgeCollection));
        };

        return array_walk($result['attached'], $sendNotification, $badges);
    }
}

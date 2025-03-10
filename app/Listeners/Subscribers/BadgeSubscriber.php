<?php

namespace Xetaravel\Listeners\Subscribers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Xetaravel\Events\Badges\ExperiencesEvent;
use Xetaravel\Events\Badges\PostEvent;
use Xetaravel\Events\Badges\PostSolvedEvent;
use Xetaravel\Events\Badges\LeaderboardEvent;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Events\Badges\CommentEvent;
use Xetaravel\Models\Badge;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;
use Xetaravel\Notifications\BadgeNotification;

class BadgeSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        RegisterEvent::class => 'onNewRegister',
        PostEvent::class => 'onNewPost',
        PostSolvedEvent::class => 'onNewPostSolved',
        ExperiencesEvent::class => 'onNewExperiences',
        LeaderboardEvent::class => 'onNewLeaderboard'
    ];

    /**
     * Register the listeners for the subscriber.
     *
     * @param Illuminate\Events\Dispatcher $events
     *
     * @return void
     */
    public function subscribe($events)
    {
        foreach ($this->events as $event => $action) {
            $events->listen($event, BadgeSubscriber::class . '@' . $action);
        }
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
     * Listener related to the posts badge.
     *
     * @param \Xetaravel\Events\PostEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewPost(PostEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewPost')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            return $badge->rule <= $user->discuss_post_count;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the post solved badge.
     *
     * @param \Xetaravel\Events\PostSolvedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewPostSolved(PostSolvedEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewPostSolved')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            $postsSolved = DiscussPost::where('user_id', $user->id)
                    ->where('is_solved', true)
                    ->count();

            return $badge->rule <= $postsSolved;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the experiences badge.
     *
     * @param \Xetaravel\Events\ExperiencesEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewExperiences(ExperiencesEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewExperiences')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            return $badge->rule <= $user->experiences_total;
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
     * Listener related to the leaderboard badge.
     *
     * @param \Xetaravel\Events\RegisterEvent $event The event that was fired.
     *
     * @return bool
     */
    public function onNewLeaderboard(LeaderboardEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'topLeaderboard')->get();

        $result = $user->badges()->syncWithoutDetaching($badges);

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

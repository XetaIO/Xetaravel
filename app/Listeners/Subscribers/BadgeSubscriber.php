<?php

declare(strict_types=1);

namespace Xetaravel\Listeners\Subscribers;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueueAfterCommit;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Events\Dispatcher;
use Xetaravel\Events\Badges\ExperienceEvent;
use Xetaravel\Events\Badges\LeaderboardEvent;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Events\Blog\CommentWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasSolvedEvent;
use Xetaravel\Models\Badge;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;
use Xetaravel\Notifications\BadgeNotification;

class BadgeSubscriber implements ShouldQueueAfterCommit
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected array $events = [
        CommentWasCreatedEvent::class => 'handleNewComment',
        RegisterEvent::class => 'handleNewRegister',
        PostWasCreatedEvent::class => 'handleNewPost',
        PostWasSolvedEvent::class => 'handleNewPostSolved',
        ExperienceEvent::class => 'handleNewExperiences',
        LeaderboardEvent::class => 'handleNewLeaderboard'
    ];

    /**
     * Send a notification for each new badge unlocked.
     *
     * @param array $result The result of the synchronization.
     * @param Collection $badges The badges collection related to the listener.
     * @param User $user The user to notify.
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
                return $badge->id === $badgeId;
            })->first();

            $user->notify(new BadgeNotification($badgeCollection));
        };

        return array_walk($result['attached'], $sendNotification, $badges);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     *
     * @return void
     */
    public function subscribe(Dispatcher $events): void
    {
        foreach ($this->events as $event => $action) {
            $events->listen($event, self::class . '@' . $action);
        }
    }

    /**
     * Listener related to the comment badge.
     *
     * @param CommentWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleNewComment(CommentWasCreatedEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewComment')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            return $badge->rule <= $user->blog_comment_count;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the posts badge.
     *
     * @param PostWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleNewPost(PostWasCreatedEvent $event): bool
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
     * @param PostWasSolvedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleNewPostSolved(PostWasSolvedEvent $event): bool
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
     * @param ExperienceEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleNewExperiences(ExperienceEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'onNewExperience')->get();

        $collection = $badges->filter(function ($badge) use ($user) {
            return $badge->rule <= $user->experiences_total;
        });

        $result = $user->badges()->syncWithoutDetaching($collection);

        return $this->sendNotifications($result, $badges, $user);
    }

    /**
     * Listener related to the register badge.
     *
     * @param RegisterEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleNewRegister(RegisterEvent $event): bool
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
     * @param LeaderboardEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleNewLeaderboard(LeaderboardEvent $event): bool
    {
        $user = $event->user;
        $badges = Badge::where('type', 'topLeaderboard')->get();

        $result = $user->badges()->syncWithoutDetaching($badges);

        return $this->sendNotifications($result, $badges, $user);
    }
}

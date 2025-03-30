<?php

declare(strict_types=1);

namespace Xetaravel\Listeners\Subscribers;

use Illuminate\Events\Dispatcher;
use Xetaravel\Events\Badges\ExperienceEvent;
use Xetaravel\Events\Blog\CommentWasCreatedEvent;
use Xetaravel\Events\Discuss\ConversationWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasSolvedEvent;
use Xetaravel\Models\Experience;
use Xetaravel\Models\User;

class ExperienceSubscriber
{
    /**
     * The experience earned for the related event.
     *
     * @var array
     */
    protected array $experiences = [
        PostWasSolvedEvent::class => 120,
        ConversationWasCreatedEvent::class => 90,
        PostWasCreatedEvent::class => 75,
        CommentWasCreatedEvent::class => 75
    ];

    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected array $events = [
        PostWasCreatedEvent::class => 'handlePostWasCreated',
        PostWasSolvedEvent::class => 'handlePostWasSolved',
        ConversationWasCreatedEvent::class => 'handleConversationWasCreated',
        CommentWasCreatedEvent::class => 'handleCommentWasCreated',
    ];

    /**
     * Create the experience.
     *
     * @param array $data The data used to create the experience.
     * @param User $user
     * @return bool
     */
    protected function create(array $data, User $user): bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $experience = Experience::create($data);

        event(new ExperienceEvent($user));

        return !(is_null($experience));
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
     * Handle a PostWasCreated event.
     *
     * @param PostWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handlePostWasCreated(PostWasCreatedEvent $event): bool
    {
        $data = [
            'amount' => $this->experiences[PostWasCreatedEvent::class],
            'obtainable_id' => $event->discussPost->getKey(),
            'obtainable_type' => get_class($event->discussPost),
            'event_type' => PostWasCreatedEvent::class
        ];

        return $this->create($data, $event->user);
    }

    /**
     * Handle a PostWasSolved event.
     *
     * @param PostWasSolvedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handlePostWasSolved(PostWasSolvedEvent $event): bool
    {
        $data = [
            'user_id' => $event->discussPost->user_id,
            'amount' => $this->experiences[PostWasSolvedEvent::class],
            'obtainable_id' => $event->discussPost->getKey(),
            'obtainable_type' => get_class($event->discussPost),
            'event_type' => PostWasSolvedEvent::class
        ];

        return $this->create($data, $event->user);
    }

    /**
     * Handle a ConversationWasCreated event.
     *
     * @param ConversationWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleConversationWasCreated(ConversationWasCreatedEvent $event): bool
    {
        $data = [
            'amount' => $this->experiences[ConversationWasCreatedEvent::class],
            'obtainable_id' => $event->discussConversation->getKey(),
            'obtainable_type' => get_class($event->discussConversation),
            'event_type' => ConversationWasCreatedEvent::class
        ];

        return $this->create($data, $event->user);
    }

    /**
     * Handle a CommentWasCreated event.
     *
     * @param CommentWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleCommentWasCreated(CommentWasCreatedEvent $event): bool
    {
        $data = [
            'amount' => $this->experiences[CommentWasCreatedEvent::class],
            'obtainable_id' => $event->blogComment->getKey(),
            'obtainable_type' => get_class($event->blogComment),
            'event_type' => CommentWasCreatedEvent::class
        ];

        return $this->create($data, $event->user);
    }
}

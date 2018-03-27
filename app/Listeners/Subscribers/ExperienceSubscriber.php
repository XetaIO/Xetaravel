<?php
namespace Xetaravel\Listeners\Subscribers;

use Xetaravel\Events\Experiences\ConversationWasCreatedEvent;
use Xetaravel\Events\Experiences\PostWasCreatedEvent;
use Xetaravel\Events\Experiences\PostWasSolvedEvent;
use Xetaravel\Models\Experience;
use Xetaravel\Models\User;

class ExperienceSubscriber
{

    /**
     * The experience earned for the related event.
     *
     * @var array
     */
    protected $experiences = [
        PostWasSolvedEvent::class => 120,
        ConversationWasCreatedEvent::class => 90,
        PostWasCreatedEvent::class => 75
    ];

    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        PostWasCreatedEvent::class => 'postWasCreated',
        PostWasSolvedEvent::class => 'postWasSolved',
        ConversationWasCreatedEvent::class => 'conversationWasCreated'
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
            $events->listen($event, ExperienceSubscriber::class . '@' . $action);
        }
    }

    /**
     * Handle a PostWasCreated event.
     *
     * @param \Xetaravel\Events\Experiences\PostWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function postWasCreated(PostWasCreatedEvent $event)
    {
        $data = [
            'amount' => $this->experiences[PostWasCreatedEvent::class],
            'obtainable_id' => $event->post->getKey(),
            'obtainable_type' => get_class($event->post),
            'event_type' => PostWasCreatedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Handle a PostWasSolved event.
     *
     * @param \Xetaravel\Events\Experiences\PostWasSolvedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function postWasSolved(PostWasSolvedEvent $event)
    {
        $data = [
            'user_id' => $event->post->user_id,
            'amount' => $this->experiences[PostWasSolvedEvent::class],
            'obtainable_id' => $event->post->getKey(),
            'obtainable_type' => get_class($event->post),
            'event_type' => PostWasSolvedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Handle a ConversationWasCreated event.
     *
     * @param \Xetaravel\Events\Experiences\ConversationWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function conversationWasCreated(ConversationWasCreatedEvent $event)
    {
        $data = [
            'amount' => $this->experiences[ConversationWasCreatedEvent::class],
            'obtainable_id' => $event->conversation->getKey(),
            'obtainable_type' => get_class($event->conversation),
            'event_type' => ConversationWasCreatedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Create the experience.
     *
     * @param array $data The data used to create the experience.
     *
     * @return bool
     */
    protected function create(array $data) : bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $experience = Experience::create($data);

        return !(is_null($experience));
    }
}

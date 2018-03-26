<?php
namespace Xetaravel\Listeners\Subscribers;

use Carbon\Carbon;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Models\UserExperience;
use Xetaravel\Models\User;

class ExperienceSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        PostWasCreatedEvent::class => 'postWasCreated',
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
     * @param \Xetaravel\Events\Discuss\PostWasCreatedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function postWasCreated(PostWasCreatedEvent $event)
    {
        $data = [
            'obtainable_id' => $event->post->getKey(),
            'obtainable_type' => get_class($event->post),
            'event_type' => PostWasCreatedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Create the log.
     *
     * @param array $data The data used to create the log.
     *
     * @return bool
     */
    protected function create(array $data) : bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $log = UserExperience::create($data);

        return !(is_null($log));
    }
}

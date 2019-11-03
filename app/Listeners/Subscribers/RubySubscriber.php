<?php
namespace Xetaravel\Listeners\Subscribers;

use Xetaravel\Events\Rubies\PostWasSolvedEvent;
use Xetaravel\Models\Ruby;
use Xetaravel\Models\User;

class RubySubscriber
{
    /**
     * The rubies earned for the related event.
     *
     * @var array
     */
    protected $rubies = [
        PostWasSolvedEvent::class => 100
    ];

    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        PostWasSolvedEvent::class => 'postWasSolved',
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
            $events->listen($event, RubySubscriber::class . '@' . $action);
        }
    }

    /**
     * Handle a PostWasSolved event.
     *
     * @param \Xetaravel\Events\Rubies\PostWasSolvedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function postWasSolved(PostWasSolvedEvent $event)
    {
        $data = [
            'user_id' => $event->post->user_id,
            'obtainable_id' => $event->post->getKey(),
            'obtainable_type' => get_class($event->post),
            'event_type' => PostWasSolvedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Create the ruby.
     *
     * @param array $data The data used to create the ruby.
     *
     * @return bool
     */
    protected function create(array $data) : bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $ruby = Ruby::create($data);

        switch ($ruby->event_type) {
            case PostWasSolvedEvent::class:
                    $ruby->user->increment('rubies_total', $this->rubies[PostWasSolvedEvent::class]);
                break;
        }

        return !(is_null($ruby));
    }
}

<?php

declare(strict_types=1);

namespace Xetaravel\Listeners\Subscribers;

use Illuminate\Events\Dispatcher;
use Xetaravel\Events\Rubies\PostWasSolvedEvent;
use Xetaravel\Models\Ruby;

class RubySubscriber
{
    /**
     * The rubies earned for the related event.
     *
     * @var array
     */
    protected array $rubies = [
        PostWasSolvedEvent::class => 100
    ];

    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected array $events = [
        PostWasSolvedEvent::class => 'postWasSolved',
    ];

    /**
     * Create the ruby.
     *
     * @param array $data The data used to create the ruby.
     *
     * @return bool
     */
    protected function create(array $data): bool
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
     * Handle a PostWasSolved event.
     *
     * @param PostWasSolvedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function postWasSolved(PostWasSolvedEvent $event): bool
    {
        $data = [
            'user_id' => $event->post->user_id,
            'obtainable_id' => $event->post->getKey(),
            'obtainable_type' => get_class($event->post),
            'event_type' => PostWasSolvedEvent::class
        ];

        return $this->create($data);
    }
}

<?php
namespace Xetaravel\Listeners\Subscribers\Discuss;

use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Models\DiscussLog;
use Xetaravel\Models\User;

class LogSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected $events = [
        CategoryWasChangedEvent::class => 'categoryWasChanged',
        ConversationWasLockedEvent::class => 'conversationWasLocked',
        ConversationWasPinnedEvent::class => 'conversationWasPinned',
        PostWasDeletedEvent::class => 'postWasDeleted',
        TitleWasChangedEvent::class => 'titleWasChanged'
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
            $events->listen($event, LogSubscriber::class . '@' . $action);
        }
    }

    /**
     * Handle a CategoryWasChanged event.
     *
     * @param \Xetaravel\Events\Discuss\CategoryWasChangedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function categoryWasChanged(CategoryWasChangedEvent $event)
    {
        $data = [
            'loggable_id' => $event->conversation->getKey(),
            'loggable_type' => get_class($event->conversation),
            'event_type' => CategoryWasChangedEvent::class,
            'data' => [
                'old' => $event->oldCategory,
                'new' => $event->category
            ]
        ];

        return $this->create($data);
    }

    /**
     * Handle a ConversationWasLocked event.
     *
     * @param \Xetaravel\Events\Discuss\ConversationWasLockedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function conversationWasLocked(ConversationWasLockedEvent $event): bool
    {
        $data = [
            'loggable_id' => $event->conversation->getKey(),
            'loggable_type' => get_class($event->conversation),
            'event_type' => ConversationWasLockedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Handle a ConversationWasPinned event.
     *
     * @param \Xetaravel\Events\Discuss\ConversationWasPinnedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function conversationWasPinned(ConversationWasPinnedEvent $event)
    {
        $data = [
            'loggable_id' => $event->conversation->getKey(),
            'loggable_type' => get_class($event->conversation),
            'event_type' => ConversationWasPinnedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Handle a PostWasDeleted event.
     *
     * @param \Xetaravel\Events\Discuss\PostWasDeletedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function postWasDeleted(PostWasDeletedEvent $event)
    {
        $data = [
            'loggable_id' => $event->conversation->getKey(),
            'loggable_type' => get_class($event->conversation),
            'event_type' => PostWasDeletedEvent::class,
            'data' => [
                'post_user_id' => $event->user->getKey()
            ]
        ];

        return $this->create($data);
    }

    /**
     * Handle a TitleWasChanged event.
     *
     * @param \Xetaravel\Events\Discuss\TitleWasChangedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function titleWasChanged(TitleWasChangedEvent $event)
    {
        $data = [
            'loggable_id' => $event->conversation->getKey(),
            'loggable_type' => get_class($event->conversation),
            'event_type' => TitleWasChangedEvent::class,
            'data' => [
                'old' => $event->oldTitle,
                'new' => $event->title
            ]
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
    protected function create(array $data): bool
    {
        if (!isset($data['data'])) {
            $data['data'] = [];
        }
        $log = DiscussLog::create($data);

        return !(is_null($log));
    }
}

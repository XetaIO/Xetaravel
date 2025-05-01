<?php

declare(strict_types=1);

namespace Xetaravel\Listeners\Subscribers\Discuss;

use Illuminate\Events\Dispatcher;
use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Models\DiscussLog;

class LogSubscriber
{
    /**
     * The events mapping to the listener function.
     *
     * @var array
     */
    protected array $events = [
        CategoryWasChangedEvent::class => 'handleCategoryWasChanged',
        ConversationWasLockedEvent::class => 'handleConversationWasLocked',
        ConversationWasPinnedEvent::class => 'handleConversationWasPinned',
        PostWasDeletedEvent::class => 'handlePostWasDeleted',
        TitleWasChangedEvent::class => 'handleTitleWasChanged'
    ];

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
     * Handle a CategoryWasChanged event.
     *
     * @param CategoryWasChangedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleCategoryWasChanged(CategoryWasChangedEvent $event): bool
    {
        $data = [
            'loggable_id' => $event->discussConversation->getKey(),
            'loggable_type' => get_class($event->discussConversation),
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
     * @param ConversationWasLockedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleConversationWasLocked(ConversationWasLockedEvent $event): bool
    {
        $data = [
            'loggable_id' => $event->discussConversation->getKey(),
            'loggable_type' => get_class($event->discussConversation),
            'event_type' => ConversationWasLockedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Handle a ConversationWasPinned event.
     *
     * @param ConversationWasPinnedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleConversationWasPinned(ConversationWasPinnedEvent $event): bool
    {
        $data = [
            'loggable_id' => $event->discussConversation->getKey(),
            'loggable_type' => get_class($event->discussConversation),
            'event_type' => ConversationWasPinnedEvent::class
        ];

        return $this->create($data);
    }

    /**
     * Handle a PostWasDeleted event.
     *
     * @param PostWasDeletedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handlePostWasDeleted(PostWasDeletedEvent $event): bool
    {
        $data = [
            'loggable_id' => $event->discussConversation->getKey(),
            'loggable_type' => get_class($event->discussConversation),
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
     * @param TitleWasChangedEvent $event The event that was fired.
     *
     * @return bool
     */
    public function handleTitleWasChanged(TitleWasChangedEvent $event): bool
    {
        $data = [
            'loggable_id' => $event->discussConversation->getKey(),
            'loggable_type' => get_class($event->discussConversation),
            'event_type' => TitleWasChangedEvent::class,
            'data' => [
                'old' => $event->oldTitle,
                'new' => $event->title
            ]
        ];

        return $this->create($data);
    }
}

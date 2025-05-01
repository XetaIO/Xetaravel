<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Subscribers\Discuss;

use Tests\TestCase;
use Xetaravel\Listeners\Subscribers\Discuss\LogSubscriber;
use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\User;

class LogSubscriberTest extends TestCase
{
    public function test_handle_category_was_changed()
    {
        $user = User::find(1);
        $this->be($user);

        $discussConversation = DiscussConversation::create([
            'category_id' => 1,
            'title' => 'Test conversation'
        ]);

        $event = new CategoryWasChangedEvent($discussConversation, 1, 2);
        $subscriber = new LogSubscriber();
        $result = $subscriber->handleCategoryWasChanged($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('discuss_logs', [
            'loggable_id' => $discussConversation->id,
            'loggable_type' => get_class($discussConversation),
            'event_type' => CategoryWasChangedEvent::class,
        ]);
    }

    public function test_handle_conversation_was_locked()
    {
        $user = User::find(1);
        $this->be($user);

        $discussConversation = DiscussConversation::create([
            'category_id' => 1,
            'title' => 'Test conversation'
        ]);

        $event = new ConversationWasLockedEvent($discussConversation);
        $subscriber = new LogSubscriber();
        $result = $subscriber->handleConversationWasLocked($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('discuss_logs', [
            'loggable_id' => $discussConversation->id,
            'event_type' => ConversationWasLockedEvent::class
        ]);
    }

    public function test_handle_conversation_was_pinned()
    {
        $user = User::find(1);
        $this->be($user);

        $discussConversation = DiscussConversation::create([
            'category_id' => 1,
            'title' => 'Test conversation'
        ]);

        $event = new ConversationWasPinnedEvent($discussConversation);
        $subscriber = new LogSubscriber();
        $result = $subscriber->handleConversationWasPinned($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('discuss_logs', [
            'loggable_id' => $discussConversation->id,
            'event_type' => ConversationWasPinnedEvent::class
        ]);
    }

    public function test_handle_post_was_deleted()
    {
        $user = User::find(1);
        $this->be($user);

        $discussConversation = DiscussConversation::create([
            'category_id' => 1,
            'title' => 'Test conversation'
        ]);

        $event = new PostWasDeletedEvent($discussConversation, $user);
        $subscriber = new LogSubscriber();
        $result = $subscriber->handlePostWasDeleted($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('discuss_logs', [
            'loggable_id' => $discussConversation->id,
            'event_type' => PostWasDeletedEvent::class
        ]);
    }

    public function test_handle_title_was_changed()
    {
        $user = User::find(1);
        $this->be($user);

        $discussConversation = DiscussConversation::create([
            'category_id' => 1,
            'title' => 'Test conversation'
        ]);

        $event = new TitleWasChangedEvent($discussConversation, 'New title', 'Old title');
        $subscriber = new LogSubscriber();
        $result = $subscriber->handleTitleWasChanged($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('discuss_logs', [
            'loggable_id' => $discussConversation->id,
            'event_type' => TitleWasChangedEvent::class
        ]);
    }
}

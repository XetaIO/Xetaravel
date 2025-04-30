<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Subscribers;

use Illuminate\Support\Facades\Event;
use Tests\TestCase;
use Xetaravel\Listeners\Subscribers\ExperienceSubscriber;
use Xetaravel\Events\Badges\ExperienceEvent;
use Xetaravel\Events\Blog\CommentWasCreatedEvent;
use Xetaravel\Events\Discuss\ConversationWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasSolvedEvent;
use Xetaravel\Models\User;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\BlogComment;

class ExperienceSubscriberTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Event::fake([ExperienceEvent::class]);
    }

    public function test_handle_post_was_created()
    {
        $user = User::find(1);
        $this->be($user);

        $discussPost = DiscussPost::create([
            'conversation_id' => 1,
            'content' => 'Test post',
        ]);
        $user->discuss_post_count = 1;
        $user->save();

        $event = new PostWasCreatedEvent($user, $discussPost);

        $subscriber = new ExperienceSubscriber();
        $result = $subscriber->handlePostWasCreated($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('experiences', [
            'user_id' => $user->id,
            'amount' => 75,
            'event_type' => PostWasCreatedEvent::class
        ]);

        Event::assertDispatched(ExperienceEvent::class, fn ($e) => $e->user->is($user));
    }

    public function test_handle_post_was_solved()
    {
        $user = User::find(1);
        $this->be($user);

        $discussPost = DiscussPost::create([
            'conversation_id' => 1,
            'content' => 'Test post',
            'is_solved' => true
        ]);

        $event = new PostWasSolvedEvent($user, $discussPost);

        $subscriber = new ExperienceSubscriber();
        $result = $subscriber->handlePostWasSolved($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('experiences', [
            'user_id' => $user->id,
            'amount' => 120,
            'event_type' => PostWasSolvedEvent::class
        ]);

        Event::assertDispatched(ExperienceEvent::class, fn ($e) => $e->user->is($user));
    }

    public function test_handle_conversation_was_created()
    {
        $user = User::find(1);
        $this->be($user);

        $discussConversation = DiscussConversation::create([
            'category_id' => 1,
            'title' => 'Test conversation'
        ]);

        $event = new ConversationWasCreatedEvent($user, $discussConversation);

        $subscriber = new ExperienceSubscriber();
        $result = $subscriber->handleConversationWasCreated($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('experiences', [
            'user_id' => $user->id,
            'amount' => 90,
            'event_type' => ConversationWasCreatedEvent::class
        ]);

        Event::assertDispatched(ExperienceEvent::class, fn ($e) => $e->user->is($user));
    }

    public function test_handle_comment_was_created()
    {
        $user = User::find(1);
        $this->be($user);

        $comment = BlogComment::create([
            'blog_article_id' => 1,
            'content' => 'Test comment',
        ]);

        $event = new CommentWasCreatedEvent($user, $comment);

        $subscriber = new ExperienceSubscriber();
        $result = $subscriber->handleCommentWasCreated($event);

        $this->assertTrue($result);
        $this->assertDatabaseHas('experiences', [
            'user_id' => $user->id,
            'amount' => 75,
            'event_type' => CommentWasCreatedEvent::class
        ]);

        Event::assertDispatched(ExperienceEvent::class, fn ($e) => $e->user->is($user));
    }
}

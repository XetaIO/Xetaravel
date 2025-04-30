<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Subscribers;

use Tests\TestCase;
use Xetaravel\Listeners\Subscribers\RubySubscriber;
use Xetaravel\Events\Discuss\PostWasSolvedEvent;
use Xetaravel\Models\User;
use Xetaravel\Models\DiscussPost;

class RubySubscriberTest extends TestCase
{
    public function test_handle_post_was_solved_creates_ruby_and_increments_user_rubies_total()
    {
        $user = User::find(1);
        $this->be($user);
        $user->rubies_total = 0;
        $user->save();

        $discussPost = DiscussPost::create([
            'conversation_id' => 1,
            'content' => 'Test post',
            'is_solved' => true
        ]);

        $event = new PostWasSolvedEvent($user, $discussPost);

        $subscriber = new RubySubscriber();
        $result = $subscriber->handlePostWasSolved($event);

        $this->assertTrue($result);

        $this->assertDatabaseHas('rubies', [
            'user_id' => $user->id,
            'obtainable_id' => $discussPost->id,
            'obtainable_type' => get_class($discussPost),
            'event_type' => PostWasSolvedEvent::class
        ]);

        $this->assertEquals(100, $user->fresh()->rubies_total);
    }
}

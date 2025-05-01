<?php

declare(strict_types=1);

namespace Tests\Unit\Listeners\Subscribers;

use Carbon\Carbon;
use Tests\TestCase;
use Xetaravel\Events\Badges\ExperienceEvent;
use Xetaravel\Events\Badges\LeaderboardEvent;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Events\Blog\CommentWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Events\Discuss\PostWasSolvedEvent;
use Xetaravel\Listeners\Subscribers\BadgeSubscriber;
use Xetaravel\Models\Badge;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\User;
use Xetaravel\Notifications\BadgeNotification;
use Illuminate\Support\Facades\Notification;

class BadgeSubscriberTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_handle_new_comment()
    {
        $user = User::find(1);
        $this->be($user);

        $badge = Badge::factory()->create([
            'type' => 'onComment',
            'rule' => 1
        ]);

        $comment = BlogComment::create([
            'blog_article_id' => 1,
            'content' => 'Test comment',
        ]);
        $user->blog_comment_count = 1;
        $user->save();

        $event = new CommentWasCreatedEvent($user, $comment);
        $subscriber = new BadgeSubscriber();

        $subscriber->handleNewComment($event);

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);

        Notification::assertSentTo($user, BadgeNotification::class);
    }

    public function test_handle_new_post()
    {
        $user = User::find(1);
        $this->be($user);

        $badge = Badge::factory()->create([
            'type' => 'onPost',
            'rule' => 1
        ]);

        $discussPost = DiscussPost::create([
            'conversation_id' => 1,
            'content' => 'Test post',
        ]);
        $user->discuss_post_count = 1;
        $user->save();

        $event = new PostWasCreatedEvent($user, $discussPost);
        $subscriber = new BadgeSubscriber();

        $subscriber->handleNewPost($event);

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);

        Notification::assertSentTo($user, BadgeNotification::class);
    }

    public function test_handle_new_post_solved()
    {
        $user = User::find(1);
        $this->be($user);
        $user->badges()->detach();

        $discussPost = DiscussPost::create([
            'conversation_id' => 1,
            'content' => 'Test post',
            'is_solved' => true
        ]);

        $badge = Badge::query()
            ->where('type', '=', 'onPostSolved')
            ->where('rule', '=', 1)
            ->first();

        $event = new PostWasSolvedEvent($user, $discussPost);
        $subscriber = new BadgeSubscriber();

        $subscriber->handleNewPostSolved($event);

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);

        Notification::assertSentTo($user, BadgeNotification::class);
    }

    public function test_handle_new_experiences()
    {
        $user = User::find(1);
        $this->be($user);

        $user->experiences_total = 50;
        $user->save();

        $badge = Badge::factory()->create([
            'type' => 'onExperience',
            'rule' => 30
        ]);

        $event = new ExperienceEvent($user);
        $subscriber = new BadgeSubscriber();

        $subscriber->handleNewExperiences($event);

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);

        Notification::assertSentTo($user, BadgeNotification::class);
    }

    public function test_handle_new_register()
    {
        Carbon::setTestNow(Carbon::create(2025, 4, 30));
        $user = User::find(1);
        $user->created_at = Carbon::now()->subYears(2);
        $user->save();
        $user->badges()->detach();

        $badge = Badge::query()
            ->where('type', '=', 'onRegister')
            ->where('rule', '=', 1)
            ->first();

        $event = new RegisterEvent($user);
        $subscriber = new BadgeSubscriber();

        $subscriber->handleNewRegister($event);

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);

        Notification::assertSentTo($user, BadgeNotification::class);
    }

    public function test_handle_new_leaderboard()
    {
        $user = User::find(1);
        $user->badges()->detach();

        $badge = Badge::query()
            ->where('type', '=', 'topLeaderboard')
            ->where('rule', '=', 1)
            ->first();

        $event = new LeaderboardEvent($user);
        $subscriber = new BadgeSubscriber();

        $subscriber->handleNewLeaderboard($event);

        $this->assertDatabaseHas('badge_user', [
            'user_id' => $user->id,
            'badge_id' => $badge->id
        ]);

        Notification::assertSentTo($user, BadgeNotification::class);
    }
}

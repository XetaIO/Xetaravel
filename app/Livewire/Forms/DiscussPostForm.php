<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussUser;
use Throwable;

class DiscussPostForm extends Form
{
    /**
     * The post to update.
     *
     * @var DiscussPost|null
     */
    public ?DiscussPost $discussPost = null;

    /**
     * The conversation id where the post belong to.
     *
     * @var int|null
     */
    #[Locked]
    public ?int $conversation_id = null;

    /**
     * The content of the post.
     *
     * @var string|null
     */
    #[Validate('required|min:10')]
    public ?string $content = null;

    /**
     * Whatever the conversation is pinned
     *
     * @var bool|null
     */
    #[Validate('boolean')]
    public ?bool $is_pinned = false;

    /**
     * Whatever the conversation is locked
     *
     * @var bool|null
     */
    #[Validate('boolean')]
    public ?bool $is_locked = false;

    private function createPost(array $properties): DiscussPost
    {
        $post = DiscussPost::create([
            'conversation_id' => $properties['conversation_id'],
            'content' => $properties['content'],
            // For unknown reason, DiscussPostObserver is not triggered
            'user_id' => Auth::id(),
        ]);


        $conversation = DiscussConversation::find($properties['conversation_id']);

        if (Auth::user()->hasPermissionTo('pin discuss conversation')) {
            if ($conversation->is_pinned !== $properties['is_pinned'] && $properties['is_pinned'] === true) {
                event(new ConversationWasPinnedEvent($conversation));
            }
            $conversation->is_pinned = $properties['is_pinned'];
        }

        if (Auth::user()->hasPermissionTo('lock discuss conversation')) {
            if ($conversation->is_locked !== $properties['is_locked'] && $properties['is_locked'] === true) {
                event(new ConversationWasLockedEvent($conversation));
            }
            $conversation->is_locked = $properties['is_locked'];
        }

        $conversation->last_post_id = $post->getKey();

        $conversation->save();

        return $post;
    }

    private function createUser(array $properties): void
    {
        DiscussUser::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'conversation_id' => $properties['conversation_id']
            ],
            [
                'conversation_id' => $properties['conversation_id']
            ]
        );
    }

    /**
     * Function to create the post.
     *
     * @return DiscussPost
     *
     * @throws Throwable
     */
    public function create(): DiscussPost
    {
        $properties = [
            'conversation_id',
            'content'
        ];

        if (Auth::user()->hasPermissionTo('pin discuss conversation')) {
            $properties[] = 'is_pinned';
        }
        if (Auth::user()->hasPermissionTo('lock discuss conversation')) {
            $properties[] = 'is_locked';
        }

        return DB::transaction(function () use ($properties) {
            $discussPost = $this->createPost($this->only($properties));
            $this->createUser($this->only($properties));

            $parser = new MentionParser($discussPost, [
                'regex' => config('mentions.regex')
            ]);
            $content = $parser->parse($discussPost->content);

            $discussPost->content = $content;
            $discussPost->save();

            event(new PostWasCreatedEvent(Auth::user(), $discussPost));

            return $discussPost;
        });
    }

    /**
     * Function to update the post.
     *
     * @return DiscussPost
     */
    public function update(): DiscussPost
    {
        $parser = new MentionParser($this->discussPost, [
            'regex' => config('mentions.regex')
        ]);
        $content = $parser->parse($this->content);

        $this->discussPost->content = $content;
        $this->discussPost->save();

        return $this->discussPost;
    }
}

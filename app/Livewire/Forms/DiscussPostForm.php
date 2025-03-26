<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussUser;

class DiscussPostForm extends Form
{
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
        $post = DiscussPost::create($this->only(['conversation_id', 'content']));

        $conversation = DiscussConversation::find($properties['conversation_id']);

        if (Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $properties['is_pinned'] = isset($properties['is_pinned']);
            $properties['is_locked'] = isset($properties['is_locked']);

            if ($conversation->is_pinned !== $properties['is_pinned'] && $properties['is_pinned'] === true) {
                event(new ConversationWasPinnedEvent($conversation));
            }

            if ($conversation->is_locked !== $properties['is_locked'] && $properties['is_locked'] === true) {
                event(new ConversationWasLockedEvent($conversation));
            }

            $conversation->is_locked = $properties['is_locked'];
            $conversation->is_pinned = $properties['is_pinned'];
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
     * Function to store the model.
     *
     * @return DiscussPost
     */
    public function store(): DiscussPost
    {
        $properties = [
            'conversation_id',
            'content'
        ];

        if (Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $properties += [
                'is_locked',
                'is_pinned',
            ];
        }

        $post = $this->createPost($this->only($properties));
        $this->createUser($this->only($properties));

        $parser = new MentionParser($post, [
            'regex' => config('mentions.regex')
        ]);
        $content = $parser->parse($post->content);

        $post->content = $content;
        $post->save();

        return $post;
    }
}

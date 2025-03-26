<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussUser;

class DiscussConversationForm extends Form
{
    /**
     * The category of the conversation
     *
     * @var int|null
     */
    #[Validate('required|integer|exists:discuss_categories,id')]
    public ?int $category_id = null;

    /**
     * The title of the conversation.
     *
     * @var string|null
     */
    #[Validate('required|min:5')]
    public ?string $title = null;

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

    /**
     * The categories used in choice.
     *
     * @var Collection|array
     */
    public Collection|array $categoriesSearchable = [];

    /**
     * The content of the post.
     *
     * @var string|null
     */
    #[Validate('required|min:10')]
    public ?string $content = null;

    /**
     * Function to store the model.
     *
     * @return DiscussConversation
     */
    public function store(): DiscussConversation
    {
        $properties = [
            'category_id',
            'title',
        ];

        if (Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $properties += [
                'is_locked',
                'is_pinned',
            ];
        }

        $discussConversation = DiscussConversation::create($this->only($properties));

        $post = DiscussPost::create([
            'conversation_id' => $discussConversation->id,
            'content' => $this->content
        ]);

        DiscussUser::create([
            'conversation_id' => $discussConversation->id,
            'is_read' => 1
        ]);

        $discussConversation->first_post_id = $post->id;
        $discussConversation->last_post_id = $post->id;
        $discussConversation->save();

        $discussConversation->category->last_conversation_id = $discussConversation->getKey();
        $discussConversation->category->save();

        $parser = new MentionParser($post, [
            'regex' => config('mentions.regex')
        ]);
        $content = $parser->parse($post->content);

        $post->content = $content;
        $post->save();

        return $discussConversation;
    }
}

<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Events\Discuss\CategoryWasChangedEvent;
use Xetaravel\Events\Discuss\ConversationWasCreatedEvent;
use Xetaravel\Events\Discuss\ConversationWasLockedEvent;
use Xetaravel\Events\Discuss\ConversationWasPinnedEvent;
use Xetaravel\Events\Discuss\TitleWasChangedEvent;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\DiscussUser;
use Throwable;

class DiscussConversationForm extends Form
{
    /**
     * The conversation to update.
     *
     * @var DiscussConversation|null
     */
    public ?DiscussConversation $discussConversation = null;

    /**
     * The category of the conversation
     *
     * @var int|null
     */
    public ?int $category_id = null;

    /**
     * The title of the conversation.
     *
     * @var string|null
     */
    public ?string $title = null;

    /**
     * Whatever the conversation is pinned
     *
     * @var bool|null
     */
    public ?bool $is_pinned = false;

    /**
     * Whatever the conversation is locked.
     *
     * @var bool|null
     */
    public ?bool $is_locked = false;

    /**
     * The content of the post, only when creating.
     *
     * @var string|null
     */
    public ?string $content = null;

    /**
     * The categories used in choice.
     *
     * @var Collection|array
     */
    public Collection|array $categoriesSearchable = [];

    /**
     * Function to store the model.
     *
     * @return DiscussConversation
     *
     * @throws Throwable
     */
    public function create(): DiscussConversation
    {
        $properties = [
            'category_id',
            'title',
        ];

        if (Auth::user()->hasPermissionTo('pin discuss conversation')) {
            $properties[] = 'is_pinned';
        }
        if (Auth::user()->hasPermissionTo('lock discuss conversation')) {
            $properties[] = 'is_locked';
        }

        return DB::transaction(function () use ($properties) {
            $discussConversation = DiscussConversation::create($this->only($properties));

            $discussPost = DiscussPost::create([
                'conversation_id' => $discussConversation->id,
                'content' => $this->content
            ]);

            DiscussUser::create([
                'conversation_id' => $discussConversation->id,
                'is_read' => 1
            ]);

            $discussConversation->first_post_id = $discussPost->id;
            $discussConversation->last_post_id = $discussPost->id;
            $discussConversation->save();

            $discussConversation->category->last_conversation_id = $discussConversation->getKey();
            $discussConversation->category->save();

            $parser = new MentionParser($discussPost, [
                'regex' => config('mentions.regex')
            ]);
            $content = $parser->parse($discussPost->content);

            $discussPost->content = $content;
            $discussPost->save();

            event(new ConversationWasCreatedEvent(Auth::user(), $discussConversation));

            return $discussConversation;
        });
    }

    /**
     * Function to update the conversation.
     *
     * @return DiscussConversation
     */
    public function update(): DiscussConversation
    {
        // The title has changed
        if ($this->discussConversation->title !== $this->title) {
            event(new TitleWasChangedEvent($this->discussConversation, $this->title, $this->discussConversation->title));

            $this->discussConversation->title = $this->title;
        }

        // The category has changed
        if ($this->discussConversation->category_id !== $this->category_id) {
            event(new CategoryWasChangedEvent($this->discussConversation, $this->category_id, $this->discussConversation->category_id));

            $this->discussConversation->category_id = $this->category_id;
        }

        // The pinned status has changed
        if (Auth::user()->hasPermissionTo('pin discuss conversation')) {
            if ($this->discussConversation->is_pinned !== $this->is_pinned && $this->is_pinned === true) {
                event(new ConversationWasPinnedEvent($this->discussConversation));
            }
            $this->discussConversation->is_pinned = $this->is_pinned;
        }

        // The locked status has changed
        if (Auth::user()->hasPermissionTo('lock discuss conversation')) {
            if ($this->discussConversation->is_locked !== $this->is_locked && $this->is_locked === true) {
                event(new ConversationWasLockedEvent($this->discussConversation));
            }
            $this->discussConversation->is_locked = $this->is_locked;
        }

        $this->discussConversation->save();

        return $this->discussConversation;
    }

    /**
     * Function to search categories.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchCategories(string $value = ''): void
    {
        $selectedOption = DiscussCategory::where('id', $this->category_id)->get();

        $categories = DiscussCategory::query()
            ->where('title', 'like', "%$value%");

        $this->categoriesSearchable = $categories->take(10)
            ->orderBy('title')
            ->get()
            ->merge($selectedOption);
    }
}

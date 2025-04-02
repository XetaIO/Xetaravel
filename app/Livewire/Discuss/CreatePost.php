<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\DiscussPostForm;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Throwable;

class CreatePost extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var DiscussPostForm
     */
    public DiscussPostForm $form;

    public function mount(DiscussConversation $discussConversation): void
    {
        $this->form->conversation_id = $discussConversation->getKey();
        $this->form->is_pinned = $discussConversation->is_pinned;
    }

    /**
     * Create a new post
     *
     * @return void
     *
     * @throws Throwable
     */
    public function create(): void
    {
        $this->authorize('create', DiscussPost::class);

        $this->validate();

        // Users that have the permission "manage discuss conversation" can bypass this rule. (Default to Developer)
        if (DiscussPost::isFlooding('xetaravel.flood.discuss.post') && !Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $this->error('Wow, keep calm bro, and try to not flood !');

            return;
        }
        $discussPost = $this->form->create();

        redirect()
            ->route('discuss.post.show', ['id' => $discussPost->getKey()])
            ->success('Your reply has been posted successfully !');
    }

    public function render()
    {
        return view('livewire.discuss.create-post');
    }

    /**
     * When a user click on 'Reply' set the content to the username#postId
     *
     * @param $content
     *
     * @return void
     */
    #[On('post-reply')]
    public function updateContent($content): void
    {
        $this->form->content = $content . $this->form->content;
    }
}

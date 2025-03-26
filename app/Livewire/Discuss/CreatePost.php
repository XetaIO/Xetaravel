<?php

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Events\Discuss\PostWasCreatedEvent;
use Xetaravel\Livewire\Forms\DiscussPostForm;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;

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
    }

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorize('create', DiscussPost::class);

        $this->validate();

        // Users that have the permission "manage.discuss" can bypass this rule. (Default to Administrator)
        if (DiscussPost::isFlooding('xetaravel.flood.discuss.post') && !Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $this->error('Wow, keep calm bro, and try to not flood !');

            return;
        }
        $discussPost = $this->form->store();

        event(new PostWasCreatedEvent(Auth::user(), $discussPost));

        redirect()
            ->route('discuss.post.show', ['id' => $discussPost->getKey()])
            ->success('Your reply has been posted successfully !');
    }


    public function render()
    {
        return view('livewire.discuss.create-post');
    }
}

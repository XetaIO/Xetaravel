<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\DiscussPostForm;
use Xetaravel\Models\DiscussPost;

class UpdatePost extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var DiscussPostForm
     */
    public DiscussPostForm $form;

    /**
     * Used to show the Edit/Create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function render()
    {
        return view('livewire.discuss.update-post');
    }

    /**
     * When a user click on 'Edit' open the modal and set the content.
     *
     * @param DiscussPost $discussPost
     *
     * @return void
     */
    #[On('update-post')]
    public function updatePost(DiscussPost $discussPost): void
    {
        $this->authorize('update', $discussPost);

        $this->form->reset();
        $this->form->discussPost = $discussPost;
        $this->form->content = $discussPost->content;

        $this->showModal = true;
    }

    /**
     * Update the post.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->discussPost);

        $this->validate();

        $discussPost = $this->form->update();

        redirect()
            ->route('discuss.post.show', ['id' => $discussPost->getKey()])
            ->success('Your reply has been edited successfully !');
    }
}

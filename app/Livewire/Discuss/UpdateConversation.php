<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\DiscussConversationForm;
use Xetaravel\Models\DiscussConversation;

class UpdateConversation extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var DiscussConversationForm
     */
    public DiscussConversationForm $form;

    /**
     * Used to show the Edit/Create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function mount(DiscussConversation $discussConversation): void
    {
        $this->form->fill([
            'discussConversation' => $discussConversation,
            'title' => $discussConversation->title,
            'category_id' => $discussConversation->category_id,
            'is_pinned' => $discussConversation->is_pinned,
            'is_locked' => $discussConversation->is_locked,
        ]);
    }

    public function render(): Factory|Application|View|\Illuminate\View\View
    {
        return view('livewire.discuss.update-conversation');
    }

    /**
     * When a user click on 'Edit' open the modal.
     *
     * @return void
     */
    #[On('update-conversation')]
    public function updateConversation(): void
    {
        $this->authorize('update', $this->form->discussConversation);

        $this->form->searchCategories();

        $this->showModal = true;
    }

    /**
     * Update the conversation.
     *
     * @return void
     */
    public function update(): void
    {
        $this->authorize('update', $this->form->discussConversation);

        $this->validate();

        $discussConversation = $this->form->update();

        redirect()
            ->route('discuss.conversation.show', ['slug' => $discussConversation->slug, 'id' => $discussConversation->getKey()])
            ->success('Your discussion has been updated successfully !');
    }

    /**
     * We must use a function in the component.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchCategories(string $value = ''): void
    {
        $this->form->searchCategories($value);
    }
}

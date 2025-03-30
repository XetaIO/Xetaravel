<?php

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\DiscussConversationForm;
use Xetaravel\Models\DiscussCategory;
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
        $this->form->discussConversation = $discussConversation;
    }

    public function render()
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

        $this->form->title = $this->form->discussConversation->title;
        $this->form->category_id = $this->form->discussConversation->category_id;
        $this->form->is_pinned = $this->form->discussConversation->is_pinned;
        $this->form->is_locked = $this->form->discussConversation->is_locked;

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

        $categories = DiscussCategory::pluckLocked('id');

        $this->validate([
            'form.title' => 'required|min:5',
            'form.category_id' => [
                'required',
                'integer',
                Rule::in($categories->toArray())
            ],
            'form.is_pinned' => 'boolean',
            'form.is_locked' => 'boolean'
        ]);

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

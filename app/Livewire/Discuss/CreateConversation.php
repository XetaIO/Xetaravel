<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\DiscussConversationForm;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;
use Throwable;

class CreateConversation extends Component
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

    public function render()
    {
        return view('livewire.discuss.create-conversation');
    }

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    #[On('create-conversation')]
    public function createConversation(): void
    {
        $this->authorize('create', DiscussConversation::class);

        $this->form->reset();
        $this->form->searchCategories();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     *
     * @throws Throwable
     */
    public function create(): void
    {
        $this->authorize('create', DiscussConversation::class);

        $this->validate();

        if (DiscussConversation::isFlooding('xetaravel.flood.discuss.conversation') &&
            !Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $this->error('Wow, keep calm bro, and try to not flood !');

            return;
        }
        $discussConversation = $this->form->create();

        $this->showModal = false;

        redirect()
            ->route('discuss.conversation.show', ['slug' => $discussConversation->slug, 'id' => $discussConversation->getKey()])
            ->success('Your discussion has been created successfully !');
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

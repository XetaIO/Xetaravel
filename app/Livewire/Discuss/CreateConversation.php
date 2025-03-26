<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Events\Discuss\ConversationWasCreatedEvent;
use Xetaravel\Livewire\Forms\DiscussConversationForm;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;

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

    /**
     * Whatever the creating url param is set or not.
     *
     * @var bool
     */
    #[Url(except: false)]
    public bool $creating = false;

    public function mount(Request $request): void
    {
        if ($request->boolean('creating') === true) {
            $this->create();

            $this->creating = false;
        }
    }

    public function render()
    {
        return view('livewire.discuss.create-conversation');
    }

    /**
     * Create a blank model and assign it to the model. (Used in create modal)
     *
     * @return void
     */
    public function create(): void
    {
        $this->authorize('create', DiscussConversation::class);

        $this->form->reset();
        $this->searchCategories();

        $this->showModal = true;
    }

    /**
     * Validate and save the model.
     *
     * @return void
     */
    public function save(): void
    {
        $this->authorize('create', DiscussConversation::class);

        $this->validate();

        if (DiscussConversation::isFlooding('xetaravel.flood.discuss.conversation') &&
            !Auth::user()->hasPermissionTo('manage discuss conversation')) {
            $this->error('Wow, keep calm bro, and try to not flood !');

            return;
        }
        $discussConversation = $this->form->store();

        event(new ConversationWasCreatedEvent(Auth::user(), $discussConversation));

        $this->showModal = false;

        redirect()
            ->route('discuss.conversation.show', ['slug' => $discussConversation->slug, 'id' => $discussConversation->getKey()])
            ->success('Your discussion has been created successfully !');
    }

    /**
     * Function to search suppliers in form.
     *
     * @param string $value
     *
     * @return void
     */
    public function searchCategories(string $value = ''): void
    {
        $selectedOption = DiscussCategory::where('id', $this->form->category_id)->get();


        $categories = DiscussCategory::query()
            ->where('title', 'like', "%$value%");

        $this->form->categoriesSearchable = $categories->take(10)
            ->orderBy('title')
            ->get()
            ->merge($selectedOption);
    }
}

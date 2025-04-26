<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Discuss;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Masmerise\Toaster\Toastable;
use Xetaravel\Models\DiscussConversation;
use Throwable;

class DeleteConversation extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var DiscussConversation
     */
    public DiscussConversation $discussConversation;

    /**
     * Used to show the Edit/Create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function mount(DiscussConversation $discussConversation): void
    {
        $this->discussConversation = $discussConversation;
    }

    public function render(): Factory|Application|View|\Illuminate\View\View
    {
        return view('livewire.discuss.delete-conversation');
    }

    /**
     * Show the confirmation modal to delete a conversation.
     *
     * @return void
     */
    #[On('delete-conversation')]
    public function deleteConversation(): void
    {
        $this->authorize('delete', $this->discussConversation);

        $this->showModal = true;
    }

    /**
     * Delete a conversation.
     *
     * @return RedirectResponse|Redirector|null
     *
     * @throws Throwable
     */
    public function delete(): Redirector|RedirectResponse|null
    {
        $this->authorize('delete', $this->discussConversation);

        // We need to re-fetch the conversation for loading relations to prevent lazy loads.
        $this->discussConversation = DiscussConversation::with('category', 'posts', 'posts.conversation', 'discussLogs')
            ->findOrFail($this->discussConversation->id);

        $result = DB::transaction(function () {
            return $this->discussConversation->delete();
        });

        if ($result) {
            return redirect()
                ->route('discuss.index')
                ->success('This discussion has been deleted successfully !');
        }

        $this->showModal = false;

        return back()
            ->error('An error occurred while deleting this discussion !');
    }
}

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
use Throwable;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Models\DiscussPost;

class DeletePost extends Component
{
    use AuthorizesRequests;
    use Toastable;

    /**
     * The form used to create/update a model.
     *
     * @var DiscussPost
     */
    public DiscussPost $discussPost;

    /**
     * Used to show the Edit/Create modal.
     *
     * @var bool
     */
    public bool $showModal = false;

    public function render(): Factory|Application|View|\Illuminate\View\View
    {
        return view('livewire.discuss.delete-post');
    }

    /**
     * Show the confirmation modal to delete a post.
     *
     * @param DiscussPost $discussPost
     *
     * @return void
     */
    #[On('delete-post')]
    public function deletePost(DiscussPost $discussPost): void
    {
        $this->authorize('delete', $discussPost);

        $this->discussPost = $discussPost;

        $this->showModal = true;
    }

    /**
     * Delete a conversation.
     *
     * @return RedirectResponse|Redirector|null
     *
     * @throws Throwable
     */
    public function delete(): RedirectResponse|Redirector|null
    {
        $this->authorize('delete', $this->discussPost);

        if ($this->discussPost->conversation->first_post_id === $this->discussPost->getKey()) {
            $this->showModal = false;
            $this->error('You can not delete the first post of a discussion !');

            return null;
        }

        $result = DB::transaction(function () {
            return $this->discussPost->delete();
        });

        if ($result) {
            event(new PostWasDeletedEvent($this->discussPost->conversation, $this->discussPost->user));

            return redirect()
                ->route(
                    'discuss.conversation.show',
                    ['id' => $this->discussPost->conversation->getKey(), 'slug' => $this->discussPost->conversation->slug]
                )
                ->success('This post has been deleted successfully !');
        }

        return redirect()
            ->route('discuss.post.show', ['id' => $this->discussPost->getKey()])
            ->error('An error occurred while deleting this post !');
    }
}

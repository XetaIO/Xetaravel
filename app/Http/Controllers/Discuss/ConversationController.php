<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\Repositories\DiscussConversationRepository;
use Xetaravel\Models\Validators\DiscussConversationValidator;

class ConversationController extends Controller
{
    /**
     * Get the current page for the conversation.
     *
     * @param Request $request
     *
     * @return int
     */
    protected function getCurrentPage(Request $request): int
    {
        return !is_null($request->get('page')) ? (int) $request->get('page') : 1;
    }
    /**
     * Show the conversation by its id.
     *
     * @return Factory|View|Application|\Illuminate\View\View|object
     */
    public function show(Request $request, string $slug, int $id)
    {
        $conversation = DiscussConversation::findOrFail($id);
        $categories = DiscussCategory::pluckLocked('title', 'id');

        $posts = $conversation->posts()
            ->with('user')
            ->where('id', '!=', $conversation->solved_post_id)
            ->where('id', '!=', $conversation->first_post_id)
            ->paginate(config('xetaravel.pagination.discuss.post_per_page'));

        $postsWithLogs = $conversation->getPostsWithLogs(
            collect($posts->items()),
            $this->getCurrentPage($request)
        );

        $breadcrumbs = $this->breadcrumbs->addCrumb(e($conversation->title), $conversation->conversation_url);

        return view(
            'Discuss::conversation.show',
            compact('conversation', 'posts', 'postsWithLogs', 'breadcrumbs', 'categories')
        );
    }


    /**
     * Handle a conversation update request for the application.
     *
     * @param Request $request
     * @param string $slug The slug of the conversation to update.
     * @param int $id The id of the conversation to update.
     *
     * @return RedirectResponse
     */
    public function update(Request $request, string $slug, int $id)
    {
        $conversation = DiscussConversation::findOrFail($id);

        $this->authorize('update', $conversation);

        DiscussConversationValidator::update($request->all(), $id)->validate();
        $conversation = DiscussConversationRepository::update($request->all(), $conversation);

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'Your discussion has been updated successfully !');
    }

    /**
     * Handle the delete request for a conversation.
     *
     * @param string $slug The slug of the conversation to delete.
     * @param int $id The id of the conversation to delete.
     *
     * @return RedirectResponse
     */
    public function delete(string $slug, int $id): RedirectResponse
    {
        $conversation = DiscussConversation::findOrFail($id);

        $this->authorize('delete', $conversation);

        if ($conversation->delete()) {
            return redirect()
                ->route('discuss.index')
                ->with('success', 'This discussion has been deleted successfully !');
        }

        return back()
            ->with('danger', 'An error occurred while deleting this discussion !');
    }
}

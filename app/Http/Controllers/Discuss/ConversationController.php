<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;

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
        $conversation = DiscussConversation::with('user', 'firstPost')->findOrFail($id);
        $categories = DiscussCategory::pluckLocked('title', 'id');

        $posts = $conversation->posts()
            ->with(['user.account', 'editedUser', 'conversation'])
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
}

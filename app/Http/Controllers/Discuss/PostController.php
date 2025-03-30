<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaravel\Events\Discuss\PostWasDeletedEvent;
use Xetaravel\Events\Discuss\PostWasSolvedEvent;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;

class PostController extends Controller
{
    /**
     * Redirect an user to a conversation, page and post.
     *
     * @param Request $request
     * @param int $id The ID of the post.
     *
     * @return RedirectResponse
     */
    public function show(Request $request, int $id): RedirectResponse
    {
        $post = DiscussPost::findOrFail($id);

        $postsBefore = DiscussPost::where([
            ['conversation_id', $post->conversation_id],
            ['created_at', '<', $post->created_at]
        ])->count();

        $postsPerPage = config('xetaravel.pagination.discuss.post_per_page');

        $page = floor($postsBefore / $postsPerPage) + 1;
        $page = ($page > 1) ? $page : 1;

        $request->session()->keep(['primary', 'error', 'warning', 'success', 'info']);

        return redirect()
            ->route(
                'discuss.conversation.show',
                [
                    'slug' => $post->conversation->slug,
                    'id' => $post->conversation->id,
                    'page' => $page,
                    '#post-' . $post->getKey()
                ]
            );
    }

    /**
     * Mark as solved.
     *
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function solved(int $id): RedirectResponse
    {
        $post = DiscussPost::findOrFail($id);

        $this->authorize('solved', $post->conversation);

        if ($post->getKey() === $post->conversation->solved_post_id) {
            return back()
                ->with('danger', 'This post is already the solved post !');
        }

        if (!is_null($post->conversation->solved_post_id)) {
            return back()
                ->with('danger', 'This conversation has already a solved post !');
        }
        $conversation = DiscussConversation::findOrFail($post->conversation_id);

        $conversation->solved_post_id = $post->getKey();
        $conversation->is_solved = true;
        $conversation->save();

        $post->is_solved = true;
        $post->save();

        event(new PostWasSolvedEvent(Auth::user(), $post));

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'This reply as been marked as solved !');
    }
}

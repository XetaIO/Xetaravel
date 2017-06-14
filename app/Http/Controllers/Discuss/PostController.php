<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussPost;
use Xetaravel\Models\Repositories\DiscussPostRepository;
use Xetaravel\Models\Repositories\DiscussUserRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\DiscussPostValidator;

class PostController extends Controller
{
    /**
     * Create a post for a conversation.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $conversation = DiscussConversation::findOrFail($request->conversation_id);

        if (DiscussPost::isFlooding('xetaravel.flood.discuss.post')) {
            return back()
                ->withInput()
                ->with('danger', 'Wow, keep calm bro, and try to not flood !');
        }

        DiscussPostValidator::create($request->all())->validate();
        $post = DiscussPostRepository::create($request->all());
        $user = DiscussUserRepository::create($request->all());

        $parser = new MentionParser($post);
        $content = $parser->parse($post->content);

        $post->content = $content;
        $post->save();

        return redirect()
            ->route('discuss.post.show', ['id' => $post->getKey()])
            ->with('success', 'Your reply has been posted successfully !');
    }

    /**
     * Redirect an user to a conversation, page and post.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The ID of the post.
     *
     * @return \Illuminate\Http\RedirectResponse
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

        $request->session()->keep(['primary', 'danger', 'warning', 'success', 'info']);

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
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function solved(Request $request, int $id): RedirectResponse
    {
        $post = DiscussPost::findOrFail($id);

        if ($post->getKey() == $post->conversation->solved_post_id) {
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

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'This reply as been marked as solved !');
    }
}

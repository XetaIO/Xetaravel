<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Events\Experiences\PostWasCreatedEvent;
use Xetaravel\Events\Experiences\PostWasSolvedEvent;
use Xetaravel\Events\Rubies\PostWasSolvedEvent as RubiesPostWasSolvedEvent;
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

        // Users that have the permission "manage.discuss" can bypass this rule. (Default to Administrator)
        if (DiscussPost::isFlooding('xetaravel.flood.discuss.post') && !Auth::user()->hasPermission('manage.discuss')) {
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

        event(new PostWasCreatedEvent($post, Auth::user()));

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
     * Handle a delete action for the post.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $post = DiscussPost::findOrFail($id);

        $this->authorize('delete', $post);

        if ($post->conversation->first_post_id == $post->getKey()) {
            return redirect()
                ->route('discuss.post.show', ['id' => $post->getKey()])
                ->with('danger', 'You can not delete the first post of a discussion !');
        }

        if ($post->delete()) {
            return redirect()
                ->route(
                    'discuss.conversation.show',
                    ['id' => $post->conversation->getKey(), 'slug' => $post->conversation->slug]
                )
                ->with('success', 'This post has been deleted successfully !');
        }

        return redirect()
            ->route('discuss.post.show', ['id' => $post->getKey()])
            ->with('danger', 'An error occurred while deleting this post !');
    }

    /**
     * Mark as solved.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function solved(int $id): RedirectResponse
    {
        $post = DiscussPost::findOrFail($id);

        $this->authorize('solved', $post);

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

        $post->is_solved = true;
        $post->save();

        event(new PostWasSolvedEvent($post, Auth::user()));

        event(new RubiesPostWasSolvedEvent($post, Auth::user()));

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'This reply as been marked as solved !');
    }

    /**
     * Handle an edit action for the post.
     *
     * @param Request $request
     * @param int $id The id of the post to edit.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request, int $id) : RedirectResponse
    {
        $post = DiscussPost::findOrFail($id);

        if (!Auth::user()->can('update', $post)) {
            return back()
                ->with('danger', 'You\'re not authorized to edit this message.');
        }

        DiscussPostValidator::edit($request->all())->validate();

        $parser = new MentionParser($post);
        $content = $parser->parse($request->input('content'));

        $post->content = $content;
        $post->is_edited = true;
        $post->edit_count++;
        $post->edited_user_id = Auth::id();
        $post->edited_at = Carbon::now();
        $post->save();

        return redirect()
            ->route('discuss.post.show', ['id' => $id])
            ->with('success', 'Your post has been edited successfully !');
    }

    /**
     * Get the edit json template.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function editTemplate(int $id)
    {
        $post = DiscussPost::find($id);

        if (!Auth::user()->can('update', $post) || !$post) {
            return response()->json([
                'error' => true,
                'message' => 'You\'re not authorized to edit this message or this message has been deleted.'
            ]);
        }

        return response(
            view('Discuss::post.editTemplate', ['post' => $post]),
            200,
            ['Content-Type' => 'application/json']
        );
    }
}

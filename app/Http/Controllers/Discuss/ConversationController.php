<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussLog;
use Xetaravel\Events\Experiences\ConversationWasCreatedEvent;
use Xetaravel\Models\Repositories\DiscussConversationRepository;
use Xetaravel\Models\Validators\DiscussConversationValidator;

class ConversationController extends Controller
{
    /**
     * Show the conversation by its id.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $slug, int $id)
    {
        $conversation = DiscussConversation::findOrFail($id);
        $categories = DiscussCategory::pluckLocked('title', 'id');

        $posts = $conversation->posts()
            ->where('id', '!=', $conversation->solved_post_id)
            ->where('id', '!=', $conversation->first_post_id)
            ->paginate(config('xetaravel.pagination.discuss.post_per_page'));

        $postsWithLogs = $conversation->getPostsWithLogs(
            collect($posts->items()),
            $this->getCurrentPage($request)
        );

        $this->breadcrumbs->setListElementClasses('breadcrumbs');
        $breadcrumbs = $this->breadcrumbs->addCrumb(e($conversation->title), $conversation->conversation_url);

        return view(
            'Discuss::conversation.show',
            compact('conversation', 'posts', 'postsWithLogs', 'breadcrumbs', 'categories')
        );
    }

    /**
     * Show the create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $categories = DiscussCategory::pluckLocked('title', 'id');

        $breadcrumbs = $this->breadcrumbs->addCrumb('Start a discussion', route('discuss.conversation.create'));

        return view('Discuss::conversation.create', compact('breadcrumbs', 'categories'));
    }

    /**
     * Handle a conversation create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        DiscussConversationValidator::create($request->all())->validate();

        // Users that have the permission "manage.discuss" can bypass this rule. (Default to Administrator)
        if (DiscussConversation::isFlooding('xetaravel.flood.discuss.conversation') &&
            !Auth::user()->hasPermission('manage.discuss')
        ) {
            return back()
                ->withInput()
                ->with('danger', 'Wow, keep calm bro, and try to not flood !');
        }
        $conversation = DiscussConversationRepository::create($request->all());
        $post = $conversation->firstPost;

        $parser = new MentionParser($post);
        $content = $parser->parse($post->content);

        $post->content = $content;
        $post->save();

        event(new ConversationWasCreatedEvent($conversation, Auth::user()));

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'Your discussion has been created successfully !');
    }

    /**
     * Handle a conversation update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug The slug of the conversation to update.
     * @param int $id The id of the conversation to update.
     *
     * @return \Illuminate\Http\RedirectResponse
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $slug, int $id) : RedirectResponse
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

    /**
     * Get the current page for the conversation.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return int
     */
    protected function getCurrentPage(Request $request): int
    {
        return !is_null($request->get('page')) ? (int)$request->get('page') : 1;
    }
}

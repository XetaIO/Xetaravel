<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;
use Xetaravel\Models\DiscussLog;
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

        if (DiscussConversation::isFlooding('xetaravel.flood.discuss.conversation')) {
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

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'Your discussion has been created successfully !');
    }

    /**
     * Handle a conversation update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $slug, int $id)
    {
        $conversation = DiscussConversation::findOrFail($id);

        DiscussConversationValidator::update($request->all(), $id)->validate();
        $conversation = DiscussConversationRepository::update($request->all(), $conversation);

        return redirect()
            ->route('discuss.conversation.show', ['slug' => $conversation->slug, 'id' => $conversation->getKey()])
            ->with('success', 'Your conversation has been updated successfully !');
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
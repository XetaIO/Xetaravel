<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussThread;
use Xetaravel\Models\DiscussLog;
use Xetaravel\Models\Repositories\DiscussThreadRepository;
use Xetaravel\Models\Validators\DiscussThreadValidator;

class ThreadController extends Controller
{
    /**
     * Show the thread by its id.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $slug, int $id)
    {
        $thread = DiscussThread::findOrFail($id);

        $comments = $thread->comments()
            ->where('id', '!=', $thread->solved_comment_id)
            ->paginate(config('xetaravel.pagination.discuss.comment_per_page'));
        $comments->load('user');

        $commentsWithLogs = $thread->getCommentWithLogs(
            collect($comments->items()),
            $this->getCurrentPage($request)
        );

        $this->breadcrumbs->setListElementClasses('breadcrumbs');
        $breadcrumbs = $this->breadcrumbs->addCrumb(e($thread->title), $thread->thread_url);

        return view('Discuss::thread.show', compact('thread', 'comments', 'commentsWithLogs', 'breadcrumbs'));
    }

    /**
     * Show the create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $categories = DiscussCategory::pluck('title', 'id');

        $breadcrumbs = $this->breadcrumbs->addCrumb('Start a discussion', route('discuss.thread.create'));

        return view('Discuss::thread.create', compact('breadcrumbs', 'categories'));
    }

    /**
     * Handle a thread create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        DiscussThreadValidator::create($request->all())->validate();

        if (DiscussThread::isFlooding(Auth::user(), 'xetaravel.flood.discuss.thread')) {
            return back()
                ->withInput()
                ->with('danger', 'Wow, keep calm bro, and try to not flood !');
        }
        $thread = DiscussThreadRepository::create($request->all());

        $parser = new MentionParser($thread);
        $content = $parser->parse($thread->content);

        $thread->content = $content;
        $thread->save();

        return redirect()
            ->route('discuss.thread.show', ['slug' => $thread->slug, 'id' => $thread->getKey()])
            ->with('success', 'Your discussion has been created successfully !');
    }

    /**
     * Get the current page for the thread.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return int
     */
    protected function getCurrentPage(Request $request)
    {
        return !is_null($request->get('page')) ? (int)$request->get('page') : 1;
    }
}

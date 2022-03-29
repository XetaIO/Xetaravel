<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Xetaravel\Models\DiscussConversation;

class SearchController extends Controller
{

    /**
     * Show the search update form.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $conversations = DiscussConversation::where('title', 'like', '%' . $search . '%')
            ->orWhereHas('posts', function ($query) use ($search) {
                return $query->where('content', 'like', '%' . $search . '%');
            })
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('xetaravel.pagination.discuss.conversation_per_page'));

        $this->breadcrumbs->addCrumb('Search : ' . $search, route('users.account.index'));

        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::search.index', compact('breadcrumbs', 'conversations', 'search'));
    }
}

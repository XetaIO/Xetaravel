<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\DiscussConversation;

class DiscussController extends Controller
{
    /**
     * Display all conversations.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $conversations = DiscussConversation::with('User', 'Category', 'FirstPost', 'LastPost')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('xetaravel.pagination.discuss.conversation_per_page'));

        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::index', compact('breadcrumbs', 'conversations'));
    }
}

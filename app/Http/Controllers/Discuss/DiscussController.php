<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\DiscussThread;

class DiscussController extends Controller
{
    public function index(): View
    {
        $threads = DiscussThread::with('User', 'Category', 'LastComment')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('xetaravel.pagination.discuss.thread_per_page'));

        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::index', compact('breadcrumbs', 'threads'));
    }
}

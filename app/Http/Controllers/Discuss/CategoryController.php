<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\View\View;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\DiscussConversation;

class CategoryController extends Controller
{
    /**
     * View all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $categories = DiscussCategory::orderBy('title', 'asc')->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb('All Categories', route('discuss.category.index'));

        return view('Discuss::category.index', compact('categories', 'breadcrumbs'));
    }

    /**
     * Display all conversations related to the category.
     *
     * @return \Illuminate\View\View
     */
    public function show(string $slug, int $id): View
    {
        $category = DiscussCategory::findOrFail($id);

        $conversations = DiscussConversation::where('category_id', $category->getKey())
            ->with('User', 'Category', 'FirstPost', 'LastPost')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(config('xetaravel.pagination.discuss.conversation_per_page'));

        $this->breadcrumbs->addCrumb('Categories', route('discuss.category.index'));

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            e($category->title),
            route('discuss.category.show', ['slug' => $category->slug,'id' => $category->getKey()])
        );

        return view('Discuss::category.show', compact('breadcrumbs', 'conversations', 'category'));
    }
}

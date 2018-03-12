<?php
namespace Xetaravel\Http\Controllers\Admin\Discuss;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\DiscussCategory;
use Xetaravel\Models\Repositories\DiscussCategoryRepository;
use Xetaravel\Models\Validators\DiscussCategoryValidator;

class CategoryController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Discuss', route('admin.discuss.category.index'));
    }

    /**
     * Show all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $categories = DiscussCategory::paginate(config('xetaravel.pagination.discuss.conversation_per_page'));

        $this->breadcrumbs->addCrumb('Manage Categories', route('admin.discuss.category.index'));

        return view(
            'Admin::Discuss.category.index',
            ['categories' => $categories, 'breadcrumbs' => $this->breadcrumbs]
        );
    }

    /**
     * Show the caterory create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Categories', route('admin.discuss.category.index'))
            ->addCrumb("Create", route('admin.discuss.category.create'));

        return view('Admin::Discuss.category.create', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Handle a category create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        DiscussCategoryValidator::create($request->all())->validate();
        DiscussCategoryRepository::create($request->all());

        return redirect()
            ->route('admin.discuss.category.index')
            ->with('success', 'Your category has been created successfully !');
    }

    /**
     * Show the category update form.
     *
     * @param string $slug The slug of the category.
     * @param int $id The id of the category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(string $slug, int $id)
    {
        $category = DiscussCategory::findOrFail($id);

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Categories', route('admin.discuss.category.index'))
            ->addCrumb(
                "Update : " . e(str_limit($category->title, 30)),
                route(
                    'admin.discuss.category.index',
                    ['slug' => $category->slug, 'id' => $category->id]
                )
            );

        return view('Admin::Discuss.category.update', compact('category', 'breadcrumbs'));
    }

    /**
     * Handle an category update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the category.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $category = DiscussCategory::findOrFail($id);

        DiscussCategoryValidator::update($request->all(), $id)->validate();
        DiscussCategoryRepository::update($request->all(), $category);

        return redirect()
            ->route('admin.discuss.category.index')
            ->with('success', 'Your category has been updated successfully !');
    }

    /**
     * Handle the delete request for the category.
     *
     * @param int $id The id of the category to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $category = DiscussCategory::findOrFail($id);

        if ($category->delete()) {
            return redirect()
                ->route('admin.discuss.category.index')
                ->with('success', 'This category has been deleted successfully !');
        }

        return redirect()
            ->route('admin.discuss.category.index')
            ->with('danger', 'An error occurred while deleting this category !');
    }
}

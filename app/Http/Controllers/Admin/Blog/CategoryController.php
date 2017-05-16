<?php
namespace Xetaravel\Http\Controllers\Admin\Blog;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Category;
use Xetaravel\Models\Repositories\CategoryRepository;
use Xetaravel\Models\Validators\CategoryValidator;

class CategoryController extends Controller
{
    /**
     * Show all categories.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $categories = Category::paginate(config('xetaravel.pagination.blog.article_per_page'));

        $this->breadcrumbs->addCrumb('Manage Categories', route('admin.blog.category.index'));

        return view('Admin::Blog.category.index', ['categories' => $categories, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the caterory create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Categories', route('admin.blog.category.index'))
            ->addCrumb("Create", route('admin.blog.category.create'));

        return view('Admin::Blog.category.create', ['breadcrumbs' => $this->breadcrumbs]);
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
        CategoryValidator::create($request->all())->validate();

        if (CategoryRepository::create($request->all())) {
            return redirect()
                ->route('admin.blog.category.index')
                ->with('success', 'Your category has been created successfully !');
        }

        return redirect()
            ->route('admin.blog.category.index')
            ->with('danger', 'An error occurred while creating your category !');
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
        $category = Category::find($id);

        if (is_null($category)) {
            return redirect()
                ->route('admin.blog.category.index')
                ->with('danger', 'This category doesn\'t exist or has been deleted !');
        }

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Categories', route('admin.blog.category.index'))
            ->addCrumb(
                "Update : " . e(str_limit($category->title, 30)),
                route(
                    'admin.blog.category.index',
                    ['slug' => $category->slug, 'id' => $category->id]
                )
            );

        return view('Admin::Blog.category.update', compact('category', 'breadcrumbs'));
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
        CategoryValidator::update($request->all(), $id)->validate();

        $category = Category::find($id);

        if (CategoryRepository::update($request->all(), $category)) {
            return redirect()
                ->route('admin.blog.category.index')
                ->with('success', 'Your category has been updated successfully !');
        }

        return redirect()
            ->route('admin.blog.category.index')
            ->with('danger', 'An error occurred while updating your category !');
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
        $category = Category::find($id);

        if (is_null($category)) {
            return redirect()
                ->route('admin.blog.category.index')
                ->with('danger', 'This category doesn\'t exist or has already been deleted !');
        }

        if ($category->delete()) {
            return redirect()
                ->route('admin.blog.category.index')
                ->with('success', 'This category has been deleted successfully !');
        }

        return redirect()
            ->route('admin.blog.category.index')
            ->with('danger', 'An error occurred while deleting this category !');
    }
}
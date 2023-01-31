<?php

namespace Xetaravel\Http\Controllers\Admin\Shop;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\ShopItem;
use Xetaravel\Models\ShopCategory;
use Xetaravel\Models\Repositories\ShopItemRepository;
use Xetaravel\Models\Validators\ShopItemValidator;

class ItemController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Shop', route('admin.shop.item.index'));
    }

    /**
     * Show all articles.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->breadcrumbs->addCrumb('Manage Articles', route('admin.blog.article.index'));

        return view('Admin::Shop.item.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the item create form.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm(): View
    {
        $categories = ShopCategory::pluck('title', 'id');

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Items', route('admin.shop.item.index'))
            ->addCrumb("Create", route('admin.shop.item.create'));

        return view('Admin::Shop.item.create', compact('categories', 'breadcrumbs'));
    }

    /**
     * Handle an article create request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        ShopItemValidator::create($request->all())->validate();
        $item = ShopItemRepository::create($request->all());

        $item->save();

        // Default icon for the article.
        $icon = public_path('images/shop/default_icon.svg');

        if (!is_null($request->file('item'))) {
            $icon = $request->file('item');
        }

        $item->clearMediaCollection('item');
        $item->addMedia($icon)
            ->preservingOriginal()
            ->setName(substr(md5($item->slug), 0, 10))
            ->setFileName(
                substr(md5($item->slug), 0, 10) . '.svg'
            )
            ->toMediaCollection('item');

        return redirect()
            ->route('admin.shop.item.index')
            ->with('success', 'Your item has been created successfully !');
    }
}

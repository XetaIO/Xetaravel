<?php
namespace Xetaravel\Http\Controllers\Discuss;

use Illuminate\View\View;

class DiscussController extends Controller
{
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs;

        return view('Discuss::index', compact('breadcrumbs'));
    }
}

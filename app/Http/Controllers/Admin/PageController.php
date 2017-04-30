<?php
namespace Xetaravel\Http\Controllers\Admin;

use Xetaravel\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Admin::page.index');
    }
}

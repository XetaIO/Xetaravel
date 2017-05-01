<?php
namespace Xetaravel\Http\Controllers;

use Xetaravel\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Account', route('users_account_index'));
    }

    public function index()
    {
        $this->breadcrumbs->setCssClasses('breadcrumb');

        return view('account.index', ['breadcrumbs' => $this->breadcrumbs]);
    }
}

<?php
namespace Xetaravel\Http\Controllers;

use Xetaravel\Models\User;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('User', route('users_account_index'));
    }

    public function index()
    {
        return view('account.index');
    }
}

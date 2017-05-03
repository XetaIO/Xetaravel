<?php
namespace Xetaravel\Http\Controllers;

use Xetaravel\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Users', route('users_user_index'));
    }

    /**
     * Show the account update form.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        return view('user.index');
    }

    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, $slug, $id)
    {
        $user = User::with('articles', 'comments')
            ->where('id', $id)
            ->first();

        if (is_null($user)) {
            return redirect()
                ->route('page_index')
                ->with('danger', 'This user doesn\'t exist or has been deleted !');
        }

        $this->breadcrumbs->addCrumb(
            e($user->username),
            route(
                'users_user_show',
                ['slug' => $user->slug, 'id' => $user->id]
            )
        );
        $this->breadcrumbs->setCssClasses('breadcrumb');

        return view('user.show', ['user' => $user, 'breadcrumbs' => $this->breadcrumbs]);
    }
}

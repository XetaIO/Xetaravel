<?php
namespace Xetaravel\Http\Controllers;

use Xetaravel\Models\Article;
use Xetaravel\Models\User;
use Xetaravel\Models\Comment;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Users', route('users_user_index'));
    }

    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug, $id)
    {
        
        // Check if the article exist and if its display.
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

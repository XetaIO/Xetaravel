<?php
namespace Xetaravel\Http\Controllers\Admin\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\User;

class UserController extends Controller
{
    /**
     * Show the search page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $latestUsers = User::with(['roles'])
            ->limit(5)
            ->latest()
            ->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb('Manage Users', route('admin.user.user.index'));

        return view('Admin::User.user.index', compact('latestUsers', 'breadcrumbs'));
    }
    /**
     * Search users related to the type.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\View\View
     */
    public function search(Request $request): View
    {
        $query = User::with(['roles'])->select();
        $search = str_replace('%', '\\%', trim($request->input('search')));
        $type = trim($request->input('type'));

        switch ($type) {
            case 'username':
                $query->where('username', 'like', '%' . $search . '%');
                break;

            case 'email':
                $query->where('email', 'like', '%' . $search . '%');
                break;

            case 'register_ip':
                $query->where('register_ip', 'like', '%' . $search . '%');
                break;

            case 'last_login_ip':
                $query->where('last_login_ip', 'like', '%' . $search . '%');
                break;

            default:
                $query->where('username', 'like', '%' . $search . '%');
                $type = 'username';
                break;
        }
        $users = $query
            ->paginate(10)
            ->appends($request->except('page'));

        $breadcrumbs = $this->breadcrumbs
            ->addCrumb('Manage Users', route('admin.user.user.index'))
            ->addCrumb('Search an user', route('admin.user.user.search'));

        return view('Admin::User.user.search', compact('users', 'breadcrumbs', 'type', 'search'));
    }

    public function showUpdateForm(Request $request, string $slug, int $id)
    {
        $user = User::find($id)->with(['Account'])->first();

        return view('Admin::User.user.update', compact('user'));
    }
}

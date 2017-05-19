<?php
namespace Xetaravel\Http\Controllers\Admin\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Ultraware\Roles\Models\Role;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\UserValidator;

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

    /**
     * Show the update form.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $slug The slug of the user.
     * @param int $id The id of the user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showUpdateForm(Request $request, string $slug, int $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return redirect()
                ->route('admin.user.user.index')
                ->with('danger', 'This user doesn\'t exist or has been deleted !');
        }

        $roles = Role::pluck('name', 'id');
        $attributes = Role::pluck('id')->toArray();

        $optionsAttributes = [];
        foreach ($attributes as $attribute) {
            $optionsAttributes[$attribute] = [
                'style' => Role::where('id', $attribute)->select('css')->first()->css
            ];
        }

        $breadcrumbs = $this->breadcrumbs
            ->setCssClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
            ->addCrumb('Manage Users', route('admin.user.user.index'))
            ->addCrumb(
                'Edit ' . e($user->username),
                route('admin.user.user.update', $user->slug, $user->id)
            );

        return view('Admin::User.user.update', compact('user', 'roles', 'optionsAttributes', 'breadcrumbs'));
    }

    /**
     * Handle an user update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the user to update.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $user = User::find($id);

        if (is_null($user)) {
            return redirect()
                ->back()
                ->with('danger', 'This user doesn\'t exist or has been deleted !');
        }

        UserValidator::update($request->all(), $user->id)->validate();

        UserRepository::update($request->all(), $user);
        AccountRepository::update($request->get('account'), $user->id);

        $user->roles()->sync($request->get('roles'));

        return redirect()
            ->back()
            ->with('success', 'This user has been updated successfully !');
    }
}

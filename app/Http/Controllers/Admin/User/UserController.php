<?php
namespace Xetaravel\Http\Controllers\Admin\User;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Http\Controllers\Admin\Controller;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Role;
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
        $user = User::findOrFail($id);

        $roles = Role::pluck('name', 'id');
        $attributes = Role::pluck('id')->toArray();

        $optionsAttributes = [];
        foreach ($attributes as $attribute) {
            $optionsAttributes[$attribute] = [
                'style' => Role::where('id', $attribute)->select('css')->first()->css
            ];
        }

        $breadcrumbs = $this->breadcrumbs
            ->setListElementClasses('breadcrumb breadcrumb-inverse bg-inverse mb-0')
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
        $user = User::findOrFail($id);

        UserValidator::update($request->all(), $user->id)->validate();
        UserRepository::update($request->all(), $user);
        $account = AccountRepository::update($request->get('account'), $user->id);

        $parser = new MentionParser($account, ['mention' => false]);
        $signature = $parser->parse($account->signature);
        $biography = $parser->parse($account->biography);

        $account->signature = $signature;
        $account->biography = $biography;
        $account->save();

        $user->roles()->sync($request->get('roles'));

        return redirect()
            ->back()
            ->with('success', 'This user has been updated successfully !');
    }

    /**
     * Handle the delete request for the user.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The id of the user to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (!Hash::check($request->input('password'), Auth::user()->password)) {
            return redirect()
                ->back()
                ->with('danger', 'Your Password does not match !');
        }

        if ($user->delete()) {
            return redirect()
                ->route('admin.user.user.index')
                ->with('success', 'This user has been deleted successfully !');
        }

        return redirect()
            ->route('admin.user.user.index')
            ->with('danger', 'An error occurred while deleting this user !');
    }

    /**
     * Delete the avatar for the specified user.
     *
     * @param int $id The id of the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAvatar(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->clearMediaCollection('avatar');
        $user->addMedia(resource_path('assets/images/avatar.png'))
            ->preservingOriginal()
            ->setName(substr(md5($user->username), 0, 10))
            ->setFileName(substr(md5($user->username), 0, 10) . '.png')
            ->toMediaCollection('avatar');

        return redirect()
            ->back()
            ->with('success', 'The avatar has been deleted successfully !');
    }
}

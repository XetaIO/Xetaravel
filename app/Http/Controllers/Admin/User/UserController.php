<?php

declare(strict_types=1);

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
     * @return View
     */
    public function index(): View
    {
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-users mr-2"></i> Manage Users',
            route('admin.user.user.index')
        );

        return view('Admin::User.user.index', compact('breadcrumbs'));
    }

    /**
     * Show the update form.
     *
     * @param Request $request
     * @param string $slug The slug of the user.
     * @param int $id The id of the user.
     *
     * @return RedirectResponse|View
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
            ->addCrumb('<i class="fa-solid fa-users mr-2"></i> Manage Users', route('admin.user.user.index'))
            ->addCrumb(
                '<i class="fa-solid fa-pen-to-square mr-2"></i> Edit ' . e($user->username),
                route('admin.user.user.update', $user->slug, $user->id)
            );

        return view('Admin::User.user.update', compact('user', 'roles', 'optionsAttributes', 'breadcrumbs'));
    }

    /**
     * Handle an user update request for the application.
     *
     * @param Request $request
     * @param int $id The id of the user to update.
     *
     * @return RedirectResponse
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
            ->route('admin.user.user.index')
            ->with('success', 'This user has been updated successfully !');
    }

    /**
     * Handle the delete request for the user.
     *
     * @param Request $request
     * @param int $id The id of the user to delete.
     *
     * @return RedirectResponse
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
     * @return RedirectResponse
     */
    public function deleteAvatar(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $user->clearMediaCollection('avatar');
        $user->addMedia(public_path('images/avatar.png'))
            ->preservingOriginal()
            ->setName(mb_substr(md5($user->username), 0, 10))
            ->setFileName(mb_substr(md5($user->username), 0, 10) . '.png')
            ->toMediaCollection('avatar');

        return redirect()
            ->back()
            ->with('success', 'The avatar has been deleted successfully !');
    }
}

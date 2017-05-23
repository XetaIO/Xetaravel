<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\UserValidator;

class UserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $action = Route::getFacadeRoot()->current()->getActionMethod();

        if (in_array($action, ['index', 'show'])) {
            $this->breadcrumbs->addCrumb('Users', route('users.user.index'));
        }
    }

    /**
     * Show all the users.
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
     * @param string $slug The slug of the user.
     * @param int $id The id of the user.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request, string $slug, int $id)
    {
        $user = User::with('articles', 'comments')
            ->where('id', $id)
            ->first();

        if (is_null($user)) {
            return redirect()
                ->route('page.index')
                ->with('danger', 'This user doesn\'t exist or has been deleted !');
        }

        $this->breadcrumbs->addCrumb(
            e($user->username),
            route(
                'users.user.show',
                ['slug' => $user->slug, 'id' => $user->id]
            )
        );
        $this->breadcrumbs->setCssClasses('breadcrumb');

        return view('user.show', ['user' => $user, 'breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show the settings form.
     *
     * @return \Illuminate\View\View
     */
    public function showSettingsForm(): View
    {
        $this->breadcrumbs
            ->addCrumb('Settings', route('users.user.settings'))
            ->setCssClasses('breadcrumb');

        return view('user.settings', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Handle an update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $type = $request->input('type');

        switch ($type) {
            case 'email':
                return $this->updateEmail($request);

            case 'password':
                return $this->updatePassword($request);

            default:
                return back()
                    ->withInput()
                    ->with('danger', 'Invalid type.');
        }
    }

    /**
     * Handle the delete request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('password'), $user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Your Password does not match !');
        }
        Auth::logout();

        if ($user->delete()) {
            return redirect()
                ->route('page.index')
                ->with('success', 'Your Account has been deleted successfully !');
        }

        return redirect()
            ->route('page.index')
            ->with('danger', 'An error occurred while deleting your account !');
    }

    /**
     * Handle a E-mail update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateEmail(Request $request): RedirectResponse
    {
        UserValidator::updateEmail($request->all())->validate();
        UserRepository::updateEmail($request->all(), Auth::user());

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Your E-mail has been updated successfully !');
    }

    /**
     * Handle a Password update request for the user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if (!Hash::check($request->input('oldpassword'), $user->password)) {
            return redirect()
                ->route('users.user.settings')
                ->with('danger', 'Your current Password does not match !');
        }

        UserValidator::updatePassword($request->all())->validate();
        UserRepository::updatePassword($request->all(), $user);

        return redirect()
            ->route('users.user.settings')
            ->with('success', 'Your Password has been updated successfully !');
    }
}

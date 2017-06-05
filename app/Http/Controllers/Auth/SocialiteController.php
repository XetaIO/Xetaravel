<?php
namespace Xetaravel\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as ProviderUser;
use Xetaravel\Events\RegisterEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\User;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Role;

class SocialiteController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect()
                ->route('users.auth.login')
                ->with('danger', 'An error occurred while getting your information from GitHub !');
        }
        $user = $this->findOrCreateUser($user);

        Auth::login($user, true);

        return $this->authenticated($request, $user) ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Xetaravel\Models\User $user The user that has been logged in.
     *
     * @return void
     */
    protected function authenticated(Request $request, $user)
    {
        event(new RegisterEvent($user));

        $request->session()->flash(
            'success',
            'Welcome back <strong>' . e($user->username) . '</strong>! You\'re successfully connected !'
        );
    }

    /**
     * Find the user if he exists or create it.
     *
     * @param \Laravel\Socialite\Two\User $providerUser
     *
     * @return \Xetaravel\Models\User
     */
    protected function findOrCreateUser(ProviderUser $providerUser): User
    {
        if ($user = User::where('github_id', $providerUser->id)->first()) {
            return $user;
        }

        $user = UserRepository::create(
            [
                'username' => $providerUser->nickname,
                'email' => $providerUser->email
            ],
            [
                'github_id' => $providerUser->id
            ],
            true
        );

        $this->registered($user);

        return $user;
    }

    /**
     * The user has been registered.
     *
     * @param \Xetaravel\Models\User $user The user that has been registered.
     *
     * @return void
     */
    protected function registered(User $user)
    {
        $role = Role::where('slug', 'user')->first();
        $user->attachRole($role);

        $user->clearMediaCollection('avatar');
        $user->addMedia(resource_path('assets/images/avatar.png'))
            ->preservingOriginal()
            ->setName(substr(md5($user->username), 0, 10))
            ->setFileName(substr(md5($user->username), 0, 10) . '.png')
            ->toMediaCollection('avatar');
    }
}

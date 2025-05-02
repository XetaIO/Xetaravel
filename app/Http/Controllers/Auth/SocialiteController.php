<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Auth;

use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as ProviderUser;
use Masmerise\Toaster\Toaster;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponseSF;
use Xetaravel\Events\Badges\RegisterEvent;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Http\Requests\Socialite\CreateRequest;
use Xetaravel\Models\User;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Role;
use Xetaravel\Models\Validators\UserValidator;

class SocialiteController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = '/';

    /**
     * The driver used.
     *
     * @var string
     */
    protected string $driver;

    /**
     * Login the user and trigger the authenticated function.
     *
     * @param Request $request The request object.
     * @param User $user The user to login.
     *
     * @return RedirectResponse
     */
    protected function login(Request $request, User $user): RedirectResponse
    {
        if (!$user->hasVerifiedEmail()) {
            return redirect(route('auth.verification.notice', sha1($user->getEmailForVerification())));
        }

        Auth::login($user, true);

        $this->authenticated($request, $user);

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Handle the registration.
     *
     * @param Request $request The request object.
     * @param ProviderUser $user The user to register.
     *
     * @return RedirectResponse|User
     *
     * @throws FileCannotBeAdded
     */
    protected function handleRegister(Request $request, ProviderUser $user)
    {
        $validator = UserValidator::createWithProvider([
            'username' => $user->nickname,
            'email' => $user->email
        ]);

        if ($validator->fails()) {
            $request->session()->put('socialite', [
                'driver' => $this->driver,
                'token' => $user->token
            ]);

            return redirect()
                ->route('auth.driver.register', ['driver' => $this->driver])
                ->withErrors($validator)
                ->withInput([
                    'username' => $user->nickname,
                    'email' => $user->email
                ]);
        }

        return $this->registered($user);
    }

    /**
     * Create the user.
     *
     * @param ProviderUser $user The user to create.
     *
     * @return User
     */
    protected function createUser(ProviderUser $user)
    {
        return UserRepository::create(
            [
                'username' => $user->nickname,
                'email' => $user->email
            ],
            [
                $this->driver . '_id' => $user->id
            ],
            true
        );
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request The request object.
     * @param User $user The user that has been logged in.
     *
     * @return void
     */
    protected function authenticated(Request $request, User $user)
    {
        event(new RegisterEvent($user));

        Toaster::success("Welcome back <strong>{$user->username}</strong>! You\'re successfully connected !");
    }

    /**
     * The user has been registered.
     *
     * @param ProviderUser $providerUser The user that has been registered.
     *
     * @return User
     * @throws FileCannotBeAdded
     */
    protected function registered(ProviderUser $providerUser): User
    {
        event(new Registered($user = $this->createUser($providerUser)));

        $this->assignDefaultRole($user);
        $this->setUserAvatar($user, $providerUser->avatar);

        return $user;
    }

    /**
     * Assign the default role to the new user.
     *
     * @param User $user
     *
     * @return void
     */
    protected function assignDefaultRole(User $user): void
    {
        $role = Role::firstWhere('name', 'User');
        $user->assignRole($role);
    }

    /**
     * Set the avatar for the new user.
     *
     * @param User $user
     * @param string|null $avatar
     * @return void
     *
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function setUserAvatar(User $user, ?string $avatar): void
    {
        $user->clearMediaCollection('avatar');

        $mediaAdder = $avatar
            ? $user->addMediaFromUrl($avatar)
            : $user->addMedia(public_path('images/avatar.png'))->preservingOriginal();

        $hashedName = mb_substr(md5($user->username), 0, 10);
        $mediaAdder
            ->setName($hashedName)
            ->setFileName("{$hashedName}.png")
            ->toMediaCollection('avatar');
    }

    /**
     * Show the registration form.
     *
     * @param Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return Factory|View|Application|\Illuminate\View\View|object|RedirectResponse
     */
    public function showRegistrationForm(Request $request, string $driver)
    {
        if (is_null($request->session()->get('socialite.driver'))) {
            return redirect()
                ->route('auth.login')
                ->error('You are not authorized to view this page!');
        }
        return view('Auth.socialite', compact('driver'));
    }

    /**
     * Register an user that has been forced to modify his email or
     * username due to a conflit with the database.
     *
     * @param CreateRequest $request The request object.
     * @param string $driver The driver used.
     *
     * @return RedirectResponse
     *
     * @throws FileCannotBeAdded
     */
    public function register(CreateRequest $request, string $driver): RedirectResponse
    {
        $request->validated();
        $this->driver = $driver;

        $user = Socialite::driver($driver)->userFromToken($request->session()->get('socialite.token'));

        $user->nickname = $request->input('username');
        $user->email = $request->input('email');

        $user = $this->registered($user);

        $request->session()->forget('socialite');

        return $this->login($request, $user);
    }

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return RedirectResponseSF
     */
    public function redirectToProvider(Request $request, string $driver): RedirectResponseSF
    {
        return Socialite::driver($driver)
                ->redirectUrl(route('auth.driver.callback', ['driver' => $driver]))
                ->redirect();
    }

    /**
     * Obtain the user information from the Provider and process to the
     * registration or login regarding the type of callback.
     *
     * @param Request $request The request object.
     * @param string $driver The driver used.
     *
     * @return RedirectResponse
     * @throws FileCannotBeAdded
     */
    public function handleProviderCallback(Request $request, string $driver): RedirectResponse
    {
        $this->driver = $driver;

        try {
            $user = Socialite::driver($driver)->user();
        } catch (Exception) {
            $driver = Str::title($driver);

            return redirect()
                ->route('auth.login')
                ->error("An error occurred while getting your information from {$driver} !");
        }

        // Check if the user is already registered
        if (!$member = User::where($driver . '_id', $user->id)->first()) {
            $register = $this->handleRegister($request, $user);
        }

        if (isset($register) && $register instanceof RedirectResponse) {
            return $register;
        }
        if (!isset($register) || !$register instanceof User) {
            $register = $member;
        }

        return $this->login($request, $register);
    }
}

<?php
namespace Xetaravel\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\User;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Role;
use Xetaravel\Models\Validators\UserValidator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(): View
    {
        return view('Auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request): RedirectResponse
    {
        UserValidator::create($request->all())->validate();

        event(new Registered($user = UserRepository::create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param \Xetaravel\Models\User $user The user that has been registered.
     *
     * @return void
     */
    protected function registered(Request $request, $user)
    {
        // Set the user role.
        $role = Role::where('slug', 'user')->first();
        $user->attachRole($role);

        // Set the default avatar.
        $user->clearMediaCollection('avatar');
        $user->addMedia(resource_path('assets/images/avatar.png'))
            ->preservingOriginal()
            ->setName(substr(md5($user->username), 0, 10))
            ->setFileName(substr(md5($user->username), 0, 10) . '.png')
            ->withCustomProperties(['primaryColor' => '#B4AEA4'])
            ->toMediaCollection('avatar');

        $request->session()->flash('success', 'Your account has been created successfully !');
    }
}

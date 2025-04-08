<?php

declare(strict_types=1);

namespace Xetaravel\Http\Controllers\Auth;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Masmerise\Toaster\Toaster;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Http\Requests\User\CreateRequest;
use Xetaravel\Models\Repositories\UserRepository;
use Xetaravel\Models\Role;
use Xetaravel\Models\User;

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
    protected string $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * The user has been registered.
     *
     * @param Request $request The request object.
     * @param User $user The user that has been registered.
     *
     * @return void
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function registered(Request $request, User $user)
    {
        // Set the user role.
        $role = Role::where('name', 'User')->first();
        $user->assignRole($role);

        // Set the default avatar.
        $user->clearMediaCollection('avatar');
        $user->addMedia(public_path('images/avatar.png'))
            ->preservingOriginal()
            ->setName(mb_substr(md5($user->username), 0, 10))
            ->setFileName(mb_substr(md5($user->username), 0, 10) . '.png')
            ->toMediaCollection('avatar');

        Toaster::success("Your account has been created successfully !");
    }

    /**
     * Show the application registration form.
     *
     * @return View
     */
    public function showRegistrationForm(): View
    {
        return view('Auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param CreateRequest $request
     *
     * @return RedirectResponse
     *
     * @throws ContainerExceptionInterface
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws NotFoundExceptionInterface
     */
    public function register(CreateRequest $request): RedirectResponse
    {
        if (!settings('app_register_enabled')) {
            return redirect('/')
                ->error('The register system is currently disabled, please try again later.');
        }
        $validated = $request->validated();

        event(new Registered($user = UserRepository::create($validated)));

        $this->guard()->login($user);

        $this->registered($request, $user);

        return redirect($this->redirectPath());
    }
}

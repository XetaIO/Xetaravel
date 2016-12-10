<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as FacadeRequest;
use Illuminate\Support\Facades\Validator;

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
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|confirmed',
            'remember' => 'required|min:1',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     *
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $ip = FacadeRequest::ip();

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'slug' => str_slug($data['username'], '-'),
            'register_ip' => $ip,
            'last_login_ip' => $ip,
            'last_login' => new \DateTime()
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param \Illuminate\Http\Request $request The request object.
     * @param mixed $user
     *
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $request->session()->flash('success', 'Your account has been created successfully !');
    }
}

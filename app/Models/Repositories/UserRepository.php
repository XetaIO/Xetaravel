<?php
namespace Xetaravel\Models\Repositories;

use Illuminate\Support\Facades\Request as FacadeRequest;
use Xetaravel\Models\User;

class UserRepository
{
    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data The data used to create the user.
     *
     * @return \Xetaravel\Models\User
     */
    public static function create(array $data): User
    {
        $ip = FacadeRequest::ip();

        return User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'register_ip' => $ip,
            'last_login_ip' => $ip,
            'last_login' => new \DateTime()
        ]);
    }
}

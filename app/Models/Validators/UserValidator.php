<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;

class UserValidator
{
    /**
     * Get the validator for an incoming registration request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function create(array $data): Validator
    {
        $rules = [
            'username' => 'required|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|confirmed',
            'terms' => 'required|min:1'
        ];

        // Bipass the captcha for the unit testing.
        if (App::environment() != 'testing') {
            $rules = array_merge($rules, ['g-recaptcha-response' => 'required|recaptcha']);
        }

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get the validator for an incoming email update request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function updateEmail(array $data): Validator
    {
        $rules = [
            'email' => 'required|email|max:50|unique:users'
        ];

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get the validator for an incoming password update request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function updatePassword(array $data): Validator
    {
        $rules = [
            'password' => 'required|min:6|confirmed'
        ];

        return FacadeValidator::make($data, $rules);
    }
}

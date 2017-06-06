<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
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
            'username' => 'required|alpha_num|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => 'required|min:6|confirmed',
            'terms' => 'required|min:1'
        ];

        // Bipass the captcha for the unit testing.
        if (App::environment() !== 'testing') {
            $rules = array_merge($rules, ['g-recaptcha-response' => 'required|recaptcha']);
        }

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get the validator for an incoming registration request with a social provider.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function createWithProvider(array $data): Validator
    {
        $rules = [
            'username' => 'required|alpha_num|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users'
        ];

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get a validator for an incoming update request. (Administration)
     *
     * @param array $data The data to validate.
     * @param int $id The actual user id to ignore the username rule.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data, int $id): Validator
    {
        $rules = [
            'username' => [
                'required',
                'alpha_num',
                'min:4',
                'max:20',
                Rule::unique('users')->ignore($id)
            ],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users')->ignore($id)
            ],
            'account.first_name' => 'max:100',
            'account.last_name' => 'max:100',
            'account.facebook' => 'max:50',
            'account.twitter' => 'max:50',
            'roles' => 'required'
        ];

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
            'oldpassword' => 'required',
            'password' => 'required|min:6|confirmed'
        ];

        return FacadeValidator::make($data, $rules);
    }
}

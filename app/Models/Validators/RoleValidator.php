<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class RoleValidator
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

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param array $data The data to validate.
     * @param int $id The actual role id to ignore the username rule.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data, int $id): Validator
    {
        $rules = [
            'name' => [
                'required',
                'min:2',
                'max:20',
                Rule::unique('roles')->ignore($id)
            ],
            'slug' => Rule::unique('roles')->ignore($id),
            'level' => 'required|integer',
            'description' => 'max:150',
            'permissions' => 'required'
        ];
        $data['slug'] = Str::slug($data['name'], config('roles.separator'));

        return FacadeValidator::make($data, $rules);
    }
}

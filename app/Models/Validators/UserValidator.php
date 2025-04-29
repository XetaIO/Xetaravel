<?php

declare(strict_types=1);

namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;

class UserValidator
{
    /**
     * Get the validator for an incoming registration request with a social provider.
     *
     * @param array $data The data to validate.
     *
     * @return Validator
     */
    public static function createWithProvider(array $data): Validator
    {
        $rules = [
            'username' => 'required|alpha_num|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users'
        ];

        return FacadeValidator::make($data, $rules);
    }
}

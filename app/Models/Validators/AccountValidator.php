<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;

class AccountValidator
{
    /**
     * Get a validator for an incoming update request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data): Validator
    {
        $rules = [
            'first_name' => 'max:100',
            'last_name' => 'max:100',
            'avatar' => 'image',
            'facebook' => 'max:50',
            'twitter' => 'max:50'
        ];

        return FacadeValidator::make($data, $rules);
    }
}

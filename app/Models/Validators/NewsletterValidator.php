<?php

declare(strict_types=1);

namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;

class NewsletterValidator
{
    /**
     * Get a validator for an incoming create request.
     *
     * @param array $data The data to validate.
     *
     * @return Validator
     */
    public static function create(array $data): Validator
    {
        $rules = [
            'email' => 'required|email|max:50|unique:newsletters'
        ];

        return FacadeValidator::make($data, $rules);
    }
}

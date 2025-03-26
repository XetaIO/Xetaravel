<?php

declare(strict_types=1);

namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;

class DiscussPostValidator
{
    /**
     * Get a validator for an incoming create request.
     *
     * @param array $data The data to validate.
     *
     * @return Validator
     */
    public static function edit(array $data): Validator
    {
        $rules = [
            'content' => 'required|min:10'
        ];

        return FacadeValidator::make($data, $rules);
    }
}

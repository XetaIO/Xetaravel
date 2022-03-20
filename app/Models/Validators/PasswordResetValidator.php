<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;

class PasswordResetValidator
{
    /**
     * Validate the email for the given request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function validateEmail(array $data): Validator
    {
        $rules = [
            'email' => 'required|email'
        ];

        // Bipass the captcha for the unit testing.
        if (App::environment() !== 'testing') {
            $rules = array_merge($rules, ['g-recaptcha-response' => 'required|captcha']);
        }

        return FacadeValidator::make($data, $rules);
    }
}

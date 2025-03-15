<?php

declare(strict_types=1);

namespace Xetaravel\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class ResetRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'email' => 'required|email'
        ];

        // Bypass the captcha for the unit testing.
        if (App::environment() !== 'testing') {
            $rules = array_merge($rules, ['g-recaptcha-response' => 'required|captcha']);
        }

        return $rules;
    }
}

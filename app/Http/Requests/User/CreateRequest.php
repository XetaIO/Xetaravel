<?php

declare(strict_types=1);

namespace Xetaravel\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Rules;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'username' => 'required|alpha_num|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => 'required|min:1'
        ];

        // Bypass the captcha for the unit testing.
        if (App::environment() !== 'testing') {
            $rules = array_merge($rules, ['g-recaptcha-response' => 'required|captcha']);
        }
        return $rules;
    }
}

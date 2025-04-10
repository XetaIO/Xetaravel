<?php

declare(strict_types=1);

namespace Xetaravel\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', 'different:current_password', Rules\Password::defaults()],
            'password_confirmation' => 'required|same:password'
        ];
    }
}

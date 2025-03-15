<?php

declare(strict_types=1);

namespace Xetaravel\Http\Requests\Password;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password' => 'current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}

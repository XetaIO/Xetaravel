<?php

declare(strict_types=1);

namespace Xetaravel\Http\Requests\Socialite;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|alpha_num|min:4|max:20|unique:users',
            'email' => 'required|email|max:50|unique:users'
        ];
    }
}

<?php

namespace Xetaravel\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmailRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:50||unique:users,email,' . $this->user()->id
        ];
    }
}

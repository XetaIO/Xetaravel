<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class SettingValidator
{
    /**
     * Get the validator for an incoming create request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function create(array $data): Validator
    {
        $rules = [
            'name' => 'required|min:3|max:30|unique:settings',
            'value' => 'required',
            'type' => [
                'required',
                Rule::in(['value_int', 'value_str', 'value_bool'])
            ],
            'description' => 'max:150'
        ];
        $data['name'] = Str::slug($data['name'], '.');

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param array $data The data to validate.
     * @param int $id The actual setting id to ignore the name rule.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data, int $id): Validator
    {
        $rules = [
            'name' => [
                'required',
                'min:3',
                'max:30',
                Rule::unique('settings')->ignore($id)
            ],
            'value' => 'required',
            'type' => [
                'required',
                Rule::in(['value_int', 'value_str', 'value_bool'])
            ],
            'description' => 'max:150'
        ];
        $data['name'] = Str::slug($data['name'], '.');

        return FacadeValidator::make($data, $rules);
    }
}

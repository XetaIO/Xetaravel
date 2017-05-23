<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class PermissionValidator
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
            'name' => 'required|min:2|max:30|unique:permissions',
            'slug' => 'unique:permissions',
            'description' => 'max:150'
        ];
        $data['slug'] = Str::slug($data['name'], config('roles.separator'));

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param array $data The data to validate.
     * @param int $id The actual permission id to ignore the name rule.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data, int $id): Validator
    {
        $rules = [
            'name' => [
                'required',
                'min:2',
                'max:30',
                Rule::unique('permissions')->ignore($id)
            ],
            'slug' => Rule::unique('permissions')->ignore($id),
            'description' => 'max:150'
        ];
        $data['slug'] = Str::slug($data['name'], config('roles.separator'));

        return FacadeValidator::make($data, $rules);
    }
}

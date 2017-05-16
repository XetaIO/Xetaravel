<?php
namespace Xetaravel\Models\Validators;

use Eloquence\Behaviours\Slug;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class CategoryValidator
{
    /**
     * Get a validator for an incoming create request.
     *
     * @param array $data The data to validate.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function create(array $data): Validator
    {
        $rules = [
            'title' => 'required|min:5',
            'slug' => 'unique:articles',
            'description' => 'required|min:10'
        ];
        $data['slug'] = Slug::fromTitle($data['title']);

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param array $data The data to validate.
     * @param int $id The actual category id to ignore the slug rule.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data, int $id): Validator
    {
        $rules = [
            'title' => 'required|min:5',
            'slug' => [
                Rule::unique('categories')->ignore($id)
            ],
            'description' => 'required|min:10'
        ];
        $data['slug'] = Slug::fromTitle($data['title']);

        return FacadeValidator::make($data, $rules);
    }
}

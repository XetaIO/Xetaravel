<?php
namespace Xetaravel\Models\Validators;

use Eloquence\Behaviours\Slug;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class DiscussThreadValidator
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
            'category_id' => 'required|integer|exists:discuss_categories,id',
            'slug' => 'unique:discuss_threads',
            'content' => 'required|min:10'
        ];
        $data['slug'] = Slug::fromTitle($data['title']);

        return FacadeValidator::make($data, $rules);
    }

    /**
     * Get a validator for an incoming update request.
     *
     * @param array $data The data to validate.
     * @param int $id The actual article id to ignore the slug rule.
     *
     * @return \Illuminate\Validation\Validator
     */
    public static function update(array $data, int $id): Validator
    {
        $rules = [
            'title' => 'required|min:5',
            'category_id' => 'required|integer|exists:discuss_categories,id',
            'slug' => [
                Rule::unique('discuss_threads')->ignore($id)
            ],
            'content' => 'required|min:10'
        ];
        $data['slug'] = Slug::fromTitle($data['title']);

        return FacadeValidator::make($data, $rules);
    }
}

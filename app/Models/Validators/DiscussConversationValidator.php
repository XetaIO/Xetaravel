<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Xetaravel\Models\DiscussCategory;

class DiscussConversationValidator
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
        $categories = DiscussCategory::pluckLocked('id');

        $rules = [
            'title' => 'required|min:5',
            'category_id' => [
                'required',
                'integer',
                Rule::in($categories->toArray())
            ],
            'content' => 'required|min:10'
        ];

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
        $categories = DiscussCategory::pluckLocked('id');

        $rules = [
            'title' => 'required|min:5',
            'category_id' => [
                'required',
                'integer',
                Rule::in($categories->toArray())
            ]
        ];

        return FacadeValidator::make($data, $rules);
    }
}

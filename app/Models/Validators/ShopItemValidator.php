<?php

namespace Xetaravel\Models\Validators;

use Eloquence\Behaviours\Slug;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ShopItemValidator
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
            'shop_category_id' => 'required',
            'title' => 'required|min:2',
            'slug' => 'unique:shop_items',
            'content' => 'required|min:5',
            'price' => 'required|numeric',
            'discount' => 'required|numeric',
            'quantity' => 'required|numeric',
            'item' => 'image'
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
            'title' => 'required|min:2',
            'shop_category_id' => 'required',
            'slug' => [
                Rule::unique('shop_items')->ignore($id)
            ],
            'content' => 'required|min:5'
        ];
        $data['slug'] = Slug::fromTitle($data['title']);

        return FacadeValidator::make($data, $rules);
    }
}

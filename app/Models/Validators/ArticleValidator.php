<?php
namespace Xetaravel\Models\Validators;

use Eloquence\Behaviours\Slug;
use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Mews\Purifier\Facades\Purifier;

class ArticleValidator
{
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
            'category_id' => 'required',
            'slug' => [
                Rule::unique('articles')->ignore($id)
            ],
            'content' => 'required|min:10'
        ];

        if (isset($data['content'])) {
            $data['content'] = Purifier::clean($data['content'], 'blog_article');
        }
        $data['slug'] = Slug::fromTitle($data['title']);

        return FacadeValidator::make($data, $rules);
    }
}

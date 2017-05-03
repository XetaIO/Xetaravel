<?php
namespace Xetaravel\Models\Validators;

use Illuminate\Support\Facades\Validator as FacadeValidator;
use Illuminate\Validation\Validator;
use Mews\Purifier\Facades\Purifier;

class CommentValidator
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
            'content' => 'required|min:10',
            'article_id' => 'required'
        ];

        if (isset($data['content'])) {
            $data['content'] = Purifier::clean($data['content'], 'blog_comment_empty');
        }

        return FacadeValidator::make($data, $rules);
    }
}

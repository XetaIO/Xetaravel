<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Livewire\Attributes\Locked;
use Livewire\Form;
use Xetaravel\Models\BlogComment;

class CommentForm extends Form
{
    #[Locked]
    public ?int $blog_article_id = null;

    public ?string $content = null;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'content' => 'required|min:10'
        ];
    }

    /**
     * Translated attribute used in failed messages.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'content' => 'commentaire'
        ];
    }

    /**
     * Function to store the model.
     *
     * @return BlogComment
     */
    public function store(): BlogComment
    {
        return BlogComment::create($this->only([
            'blog_article_id',
            'content'
        ]));
    }
}

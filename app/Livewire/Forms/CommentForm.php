<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Xetaio\Mentions\Parser\MentionParser;
use Xetaravel\Models\BlogComment;
use Throwable;

class CommentForm extends Form
{
    /**
     * The article id where the comment belong to.
     *
     * @var int|null
     */
    #[Locked]
    public ?int $blog_article_id = null;

    /**
     * The content of the comment.
     *
     * @var string|null
     */
    #[Validate('required|min:10')]
    public ?string $content = null;

    /**
     * Function to store the model.
     *
     * @return BlogComment
     *
     * @throws Throwable
     */
    public function store(): BlogComment
    {
        return DB::transaction(function () {
            $comment = BlogComment::create($this->only([
                'blog_article_id',
                'content'
            ]));

            $parser = new MentionParser($comment);
            $content = $parser->parse($this->content);
            $comment->content = $content;
            $comment->save();

            return $comment;
        });
    }
}

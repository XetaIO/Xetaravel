<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Blog;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Forms\CommentForm;
use Xetaravel\Livewire\Traits\WithCachedRows;
use Xetaravel\Livewire\Traits\WithPerPagePagination;
use Xetaravel\Livewire\Traits\WithSorting;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;

class Comment extends Component
{
    use AuthorizesRequests;
    use Toastable;
    use WithCachedRows;
    use WithPerPagePagination;
    use WithSorting;

    public BlogArticle $article;

    /**
     * The number of comment for this article.
     *
     * @var int|null
     */
    public ?int $blogCommentCount = null;

    /**
     * The form used to create a comment.
     *
     * @var CommentForm
     */
    public CommentForm $form;

    /**
     * Number of rows displayed on a page.
     *
     * @var int
     */
    public int $perPage = 3;

    /**
     * The field to sort by.
     *
     * @var string
     */
    public string $sortField = 'created_at';

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    public string $sortDirection = 'desc';

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'created_at'
    ];

    /**
     * The content of the comment.
     *
     * @var string
     */
    public string $content = '';

    public function mount(BlogArticle $article): void
    {
        $this->article = $article;
        $this->form->blog_article_id = $article->id;
        $this->blogCommentCount = $article->blog_comment_count;
    }

    public function render(): View
    {
        return view('livewire.blog.comment', [
            'comments' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = BlogComment::query()
            ->with('user', 'user.account')
            ->where('blog_article_id', $this->article->id);

        return $this->applySorting($query);
    }

    /**
     * Build the query or get it from the cache and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getRowsProperty(): LengthAwarePaginator
    {
        return $this->cache(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    /**
     * Validate and create the model.
     *
     * @return void
     *
     * @throws AuthorizationException
     */
    public function create(): void
    {
        $this->authorize('create', BlogComment::class);

        $this->validate();

        $this->form->store();

        $this->form->content = "";

        $this->success('Your comment has been created !');



        $this->blogCommentCount++;
        //$this->js('window.editor.value = \'\'');
        //$this->js('alert(window.editor.value())');
        $this->dispatch('comment-created');
    }
}

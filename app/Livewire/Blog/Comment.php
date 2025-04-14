<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Blog;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Masmerise\Toaster\Toastable;
use Xetaravel\Events\Blog\CommentWasCreatedEvent;
use Xetaravel\Livewire\Forms\CommentForm;
use Xetaravel\Livewire\Traits\WithCachedRows;
use Xetaravel\Livewire\Traits\WithPerPagePagination;
use Xetaravel\Livewire\Traits\WithSorting;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;
use Xetaravel\Models\User;
use Throwable;

class Comment extends Component
{
    use AuthorizesRequests;
    use Toastable;
    use WithCachedRows;
    use WithPerPagePagination;
    use WithSorting;

    /**
     * The article where the comments belong to.
     *
     * @var BlogArticle
     */
    public BlogArticle $article;

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
    public int $perPage = 10;

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
     * The modal used to delete a comment.
     *
     * @var bool
     */
    public bool $deleteCommentModal = false;

    /**
     * The comment id to delete.
     *
     * @var int|null
     */
    public ?int $deleteCommentId = null;

    /**
     * The number of comment for this article.
     *
     * @var int|null
     */
    public ?int $blogCommentCount = null;

    /**
     * The listeners.
     *
     * @var array
     */
    protected $listeners = [
        'deleted-event' => '$refresh'
    ];


    public function mount(BlogArticle $article): void
    {
        $this->article = $article;
        $this->form->blog_article_id = $article->id;
        $this->blogCommentCount = $article->blog_comment_count;
        $this->perPage = config('xetaravel.pagination.blog.comment_per_page');
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
     * @throws AuthorizationException|Throwable
     */
    public function create(): void
    {
        $this->authorize('create', [BlogComment::class, $this->article]);

        $this->validate();

        if (BlogComment::isFlooding('xetaravel.flood.blog.comment')) {
            $this->error('Wow, keep calm bro, and try to not flood !');

            return;
        }
        $comment = $this->form->store();

        // We must find the user else we won't see the updated blog_comment_count.
        event(new CommentWasCreatedEvent(User::find(Auth::id()), $comment));

        $this->form->content = "";
        $this->blogCommentCount++;

        $this->success('Your comment has been posted successfully !');
    }

    /**
     * Delete a comment.
     *
     * @return void
     */
    public function delete(): void
    {
        $comment = BlogComment::findOrFail($this->deleteCommentId);

        $this->authorize('delete', [$comment, $this->article]);

        if ($comment->delete()) {
            $this->success("Your comment has been deleted successfully !");
            $this->blogCommentCount--;
            $this->deleteCommentModal = false;
            $this->dispatch('deleted-event');

            return;
        }
        $this->error('Whoops, looks like something went wrong !');
    }
}

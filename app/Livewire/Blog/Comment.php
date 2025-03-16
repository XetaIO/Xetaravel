<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Blog;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Xetaravel\Livewire\Traits\WithCachedRows;
use Xetaravel\Livewire\Traits\WithPerPagePagination;
use Xetaravel\Livewire\Traits\WithSorting;
use Xetaravel\Models\BlogArticle;
use Xetaravel\Models\BlogComment;

class Comment extends Component
{
    use AuthorizesRequests;
    use WithCachedRows;
    use WithPerPagePagination;
    use WithSorting;

    public BlogArticle $article;

    /**
     * Number of rows displayed on a page.
     *
     * @var int
     */
    public int $perPage = 25;

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

    public $content;

    public function mount(BlogArticle $article): void
    {
        $this->article = $article;
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
            ->with('user', )
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
}

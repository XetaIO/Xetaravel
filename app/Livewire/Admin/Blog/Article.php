<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\Blog;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Traits\WithBulkActions;
use Xetaravel\Livewire\Traits\WithPerPagePagination;
use Xetaravel\Livewire\Traits\WithSorting;
use Xetaravel\Models\BlogArticle;

class Article extends Component
{
    use AuthorizesRequests;
    use Toastable;
    use WithBulkActions;
    use WithPagination;
    use WithPerPagePagination;
    use WithSorting;

    /**
     * Bind the main model used in the component to be used in traits.
     *
     * @var string
     */
    public string $model = BlogArticle::class;

    /**
     * The field to sort by.
     *
     * @var string
     */
    #[Url(as: 'f', except: 'created_at')]
    public string $sortField = 'created_at';

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    #[Url(as: 'd')]
    public string $sortDirection = 'desc';

    /**
     * The string to search.
     *
     * @var string
     */
    #[Url(as: 's', except: '')]
    public string $search = '';

    /**
     * The number of article limited per page.
     *
     * @var int
     */
    public int $perPage = 15;

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [
        'id',
        'user_id',
        'title',
        'blog_category_id',
        'blog_comment_count',
        'published_at',
        'created_at'
    ];

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.blog.article', [
            'articles' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = BlogArticle::query()
            ->with(['category', 'user.account'])
            ->when($this->search, function ($query, $search) {
                return $query
                    ->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('content', 'LIKE', '%' . $search . '%');
            });

        return $this->applySorting($query);
    }

    /**
     * Build the query and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getRowsProperty(): LengthAwarePaginator
    {
        return $this->applyPagination($this->rowsQuery);
    }
}

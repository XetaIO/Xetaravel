<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\Badge;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toastable;
use Xetaravel\Livewire\Traits\WithBulkActions;
use Xetaravel\Livewire\Traits\WithPerPagePagination;
use Xetaravel\Livewire\Traits\WithSorting;
use Xetaravel\Models\Badge as BadgeModel;

class Badge extends Component
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
    public string $model = BadgeModel::class;

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
     * The number of permission limited per page.
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
        'name',
        'description',
        'type',
        'created_at'
    ];

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.badge.badge', [
            'badges' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = BadgeModel::query();

        if (Gate::allows('search', BadgeModel::class)) {
            $query ->when($this->search, function ($query, $search) {
                return $query
                    ->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

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

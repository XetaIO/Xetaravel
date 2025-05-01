<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Admin\User;

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
use Xetaravel\Models\User as UserModel;

class User extends Component
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
    public string $model = UserModel::class;

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
        'username',
        'email',
        'last_login_date',
        'created_at',
        'deleted_at'
    ];

    public function mount(): void
    {
        $this->perPage = config('xetaravel.pagination.user.user_per_page', $this->perPage);
    }

    public function render(): View|Application|Factory|\Illuminate\View\View
    {
        return view('livewire.admin.user.user', [
            'users' => $this->rows
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getRowsQueryProperty(): Builder
    {
        $query = UserModel::query()
            ->with('account', 'roles');

        if (Gate::allows('search', UserModel::class)) {
            $query->when($this->search, function ($query, $search) {
                return $query
                    ->where('username', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('register_ip', 'LIKE', '%' . $search . '%')
                    ->orWhere('last_login_ip', 'LIKE', '%' . $search . '%');
            });
        }

        // Get also trashed users.
        $query->withTrashed();

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

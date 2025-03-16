<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait WithPerPagePagination
{
    use WithPagination;

    /**
     * Assign the perPage option from the session.
     *
     * @return void
     *
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function mountWithPerPagePagination(): void
    {
        $this->perPage = session()->get('perPage', $this->perPage);
    }

    /**
     * Store in session the perPage option.
     *
     * @param mixed $value The value of the option perPage.
     *
     * @return void
     */
    public function updatedPerPage(mixed $value): void
    {
        session()->put('perPage', $value);
    }

    /**
     * Apply the pagination to the query.
     *
     * @param Builder $query The query to apply the pagination.
     *
     * @return LengthAwarePaginator
     */
    public function applyPagination(Builder $query): LengthAwarePaginator
    {
        return $query->paginate($this->perPage);
    }
}

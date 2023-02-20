<?php

namespace Xetaravel\Http\Livewire\Traits;

use Illuminate\Contracts\Container\BindingResolutionException;
use Livewire\WithPagination;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;

trait WithPerPagePagination
{
    use WithPagination;

    /**
     * Assign the perPage option from the session.
     *
     * @return void
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
    public function updatedPerPage($value): void
    {
        session()->put('perPage', $value);
    }

    /**
     * Apply the pagination to the query.
     *
     * @param mixed $query The query to apply the pagination.
     *
     * @return mixed
     */
    public function applyPagination($query)
    {
        return $query->paginate($this->perPage);
    }
}

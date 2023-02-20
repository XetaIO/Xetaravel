<?php

namespace Xetaravel\Http\Livewire\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait WithSorting
{
    /**
     * The field to sort by.
     *
     * @var string
     */
    public string $sortField = 'created_at';

    /**
     * Array of allowed fields.
     *
     * @var array
     */
    public array $allowedFields = [];

    /**
     * The direction of the ordering.
     *
     * @var string
     */
    public string $sortDirection = 'desc';

    /**
     * Determine the direction regarding of the field.
     *
     * @param string $field
     *
     * @return void
     */
    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';

        if (empty($this->allowedFields) ||
            in_array($field, $this->allowedFields) ||
            $this->sortField === $field
        ) {
            $this->sortField = $field;
        }
    }

    /**
     * Apply the orderBy condition with he field and the direction to the query.
     *
     * @param Builder $query The query to apply the orderBy close.
     *
     * @return Builder
     */
    public function applySorting(Builder $query): Builder
    {
        return $query->orderBy($this->sortField, $this->sortDirection);
    }
}

<?php

declare(strict_types=1);

namespace Xetaravel\Livewire\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Masmerise\Toaster\Toastable;
use Throwable;

trait WithBulkActions
{
    use Toastable;

    /**
     * Whatever the current page of rows are all selected or not.
     *
     * @var bool
     */
    public bool $selectPage = false;

    /**
     * Whatever the user has selected all rows or not.
     *
     * @var bool
     */
    public bool $selectAll = false;

    /**
     * The id array of selected rows.
     *
     * @var Collection
     */
    public Collection $selected;

    /**
     * Filter the field on component mount regarding the allowed fields.
     *
     * @return void
     */
    public function mountWithBulkActions(): void
    {
        $this->selected = collect();
    }

    /**
     * If the selectAll is true, we need to select (and check the checkbox) of all rows
     * rendering in the current page.
     *
     * @return void
     */
    public function renderingWithBulkActions(): void
    {
        if ($this->selectAll) {
            $this->selectPageRows();
        }
    }

    /**
     * Whenever the user unselect a checkbox, we need to disable the selectAll option and selectPage.
     *
     * @return void
     */
    public function updatedSelected(): void
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    /**
     * Whatever we have selected all rows in the current page.
     *
     * @param mixed $value The current page where all rows get selected.
     *
     * @return void|null
     */
    public function updatedSelectPage($value)
    {
        if ($value) {
            $this->selectPageRows();

            return;
        }

        $this->selectAll = false;
        $this->selected = collect();
    }

    /**
     * Convert the selected rows id into string type.
     *
     * @return void
     */
    public function selectPageRows(): void
    {
        $this->selected = $this->rows->pluck('id')->map(fn ($id) => (string) $id);
    }

    /**
     * Set selectAll to true.
     *
     * @return void
     */
    public function setSelectAll(): void
    {
        $this->selectAll = true;
    }

    /**
     * Get all select rows by their id, preparing for deleting them.
     *
     * @eturn Builder
     */
    public function getSelectedRowsQueryProperty(): Builder
    {

        return app($this->model)
            ->unless($this->selectAll, function ($query) {
                return $query->whereKey($this->selected->values());
            });
    }

    /**
     * Delete all selected rows and display a flash message.
     *
     * @return bool
     *
     * @throws Throwable
     */
    public function deleteSelected(): bool
    {
        $models = new EloquentCollection(
            $this->selectedRowsQuery->with('comments')->get()->map(function ($model) {
                $this->authorize('delete', $model);
                return $model;
            })->all()
        );

        if ($models->isEmpty()) {
            return false;
        }

        DB::transaction(function () use ($models) {
            foreach ($models as $model) {
                $model->delete();
            }
        });

        $this->selected = collect();

        return true;
    }
}

<?php

namespace Xetaravel\Http\Livewire\Traits;

trait WithBulkActions
{
    /**
     * Whatever the current page of rows are all selected or not.
     *
     * @var false
     */
    public $selectPage = false;

    /**
     * Whatever the user has selected all rows or not.
     *
     * @var bool
     */
    public $selectAll = false;

    /**
     * The id array of selected rows.
     *
     * @var array
     */
    public $selected = [];

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
     * @return void
     */
    public function updatedSelectPage($value)
    {
        if ($value) {
            return $this->selectPageRows();
        }

        $this->selectAll = false;
        $this->selected = [];
    }

    /**
     * Convert the selected rows id into string type.
     *
     * @return void
     */
    public function selectPageRows(): void
    {
        $this->selected = $this->rows->pluck('id')->map(fn($id) => (string) $id);
    }

    /**
     * Set selectAll to true.
     *
     * @return void
     */
    public function selectAll(): void
    {
        $this->selectAll = true;
    }

    /**
     * Get all select rows by their id, preparing for deleting them.
     *
     * @return mixed
     */
    public function getSelectedRowsQueryProperty()
    {
        return (clone $this->rowsQuery)
            ->unless($this->selectAll, fn($query) => $query->whereKey($this->selected));
    }

    /**
     * Delete all selected rows and display a flash message.
     *
     * @return void
     */
    public function deleteSelected(): void
    {
        $deleteCount = $this->selectedRowsQuery->count();

        if ($this->selectedRowsQuery->delete()) {
            $this->fireFlash('delete', 'success', $deleteCount);
        } else {
            $this->fireFlash('delete', 'danger');
        }
        $this->showDeleteModal = false;
    }
}

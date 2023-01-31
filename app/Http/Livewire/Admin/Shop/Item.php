<?php

namespace Xetaravel\Http\Livewire\Admin\Shop;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Xetaravel\Http\Livewire\Datatable\WithSorting;
use Xetaravel\Models\ShopItem;

class Item extends Component
{
    use WithPagination;
    use WithSorting;

    /**
     * The string to search.
     *
     * @var string
     */
    public string $search = '';

    /**
     * Used to update in URL the query string.
     *
     * @var string[]
     */
    protected $queryString = ['sortField', 'sortDirection'];

    /**
     * The theme used for pagination.
     *
     * @var string
     */
    protected string $paginationTheme = 'bootstrap';

    /**
     * Function to render the component.
     *
     * @return View
     */
    public function render()
    {
        return view('livewire.admin.shop.item', [
            'items' => $this->items
        ]);
    }

    /**
     * Create and return the query for the items.
     *
     * @return Builder
     */
    public function getItemsQueryProperty(): Builder
    {
        $query = ShopItem::query()
            ->search('title', $this->search);

        return $this->applySorting($query);
    }

    /**
     * Build the query and paginate it.
     *
     * @return LengthAwarePaginator
     */
    public function getItemsProperty(): LengthAwarePaginator
    {
        return $this->itemsQuery->paginate(config('xetaravel.pagination.shop.item_per_page'));
    }
}

<div>
    <div class="row justify-content-between">
        <div class="col-lg-2 align-self-start mb-2">
            <input wire:model="search" placeholder="Search Items..." type="text" class="form-control form-control-inverse">
        </div>
        <div class="col-lg-1 align-self-start mb-2">
            {{ link_to(route('admin.shop.item.create'), '<i class="fa fa-plus"></i> New Item', ['class' => 'btn btn-outline-primary mb-2'], null, false) }}
        </div>
    </div>

    <x-table>
        <x-slot name="head">
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('shop_category_id')" :direction="$sortField === 'shop_category_id' ? $sortDirection : null">Category</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">Title</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('price')" :direction="$sortField === 'price' ? $sortDirection : null">Price</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('discount')" :direction="$sortField === 'discount' ? $sortDirection : null">Discount</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_display')" :direction="$sortField === 'is_display' ? $sortDirection : null">Is Display</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('start_at')" :direction="$sortField === 'start_at' ? $sortDirection : null">Start At</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('end_at')" :direction="$sortField === 'end_at' ? $sortDirection : null">End At</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-table.heading>
            <x-table.heading />
        </x-slot>

        <x-slot name="body">
            @forelse($items as $item)
                <x-table.row wire:loading.class.delay="opacity-50">
                    <x-table.cell>{{ $item->getKey() }}</x-table.cell>
                    <x-table.cell>{{ $item->shopCategory->title }}</x-table.cell>
                    <x-table.cell>{{ $item->title }}</x-table.cell>
                    <x-table.cell>{{ $item->price }} <i class="fa fa-diamond text-primary" aria-hidden="true"></i></x-table.cell>
                    <x-table.cell>{{ $item->discount }}</x-table.cell>
                    <x-table.cell class="font-weight-bold {{ $item->is_display ? 'text-success' : 'text-danger' }}">{{ $item->is_display ? 'Yes' : 'No' }}</x-table.cell>
                    <x-table.cell>{{ !is_null($item->start_at) ? $item->start_at->formatLocalized('%d %B %Y - %T') : "" }}</x-table.cell>
                    <x-table.cell>{{ !is_null($item->end_at) ? $item->end_at->formatLocalized('%d %B %Y - %T') : "" }}</x-table.cell>
                    <x-table.cell>{{ $item->created_at->formatLocalized('%d %B %Y - %T') }}</x-table.cell>
                    <x-table.cell>
                        {{ link_to(
                                        route('admin.shop.item.edit', ['slug' => $item->slug, 'id' => $item->id]),
                                        '<i class="fa fa-edit"></i>',
                                        [
                                            'class' => 'btn btn-sm btn-outline-info',
                                            'data-toggle' => 'tooltip',
                                            'title' => 'Edit this item'
                                        ],
                                        null,
                                        false
                                    ) }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="9">
                        <div class="text-xs-center p-2">
                            <span class="text-muted">No items found...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table>
    <div class="col-md 12 text-xs-center">
        {{ $items->links() }}
    </div>
</div>

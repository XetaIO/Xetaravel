<div>
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                {{-- Search input --}}
                <div class="w-full lg:w-auto md:min-w-[300px]">
                    <x-input icon="fas-search" wire:model.live.debounce="search" placeholder="Search Categories..." class="lg:max-w-lg" />
                </div>
                {{-- Create/Delete buttons --}}
                <div class="flex flex-col md:flex-row gap-2">
                    @if($selected?->isNotEmpty())
                        <x-button icon="fas-trash" type="button" label="Delete Categories" class="btn btn-error" wire:click="deleteSelected" spinner />
                    @endif
                    @can('create', \Xetaravel\Models\BlogCategory::class)
                        <x-button icon="fas-plus" type="button" label="New Category" class="btn btn-success categoryCreateButton" spinner />
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md  rounded-lg p-3">
            <x-table.table class="mb-6">
                <x-slot name="head">
                    <x-table.heading>
                        <label>
                            <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                        </label>
                    </x-table.heading>
                    <x-table.heading>Actions</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">Id</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('title')" :direction="$sortField === 'title' ? $sortDirection : null">Title</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('blog_article_count')" :direction="$sortField === 'blog_article_count' ? $sortDirection : null">Article(s)</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created at</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row wire:key="row-message">
                            <x-table.cell colspan="7">
                                @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $categories->count() }}</strong> categories, do you want to select all <strong>{{ $categories->total() }}</strong> categories?</span>
                                        <x-button type="button" icon="fas-check" label="Select all" wire:click='setSelectAll' class="btn-sm" spinner />
                                    </div>
                                @else
                                    <span>You have selected actually <strong>{{ $categories->total() }}</strong> categories.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse($categories as $category)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $category->getKey() }}">
                            @can('delete', $category)
                                <x-table.cell>
                                    <label>
                                        <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $category->getKey() }}" />
                                    </label>
                                </x-table.cell>
                            @endcan
                            @can('update', $category)
                                <x-table.cell>
                                    <x-button icon="fas-pen-to-square" data-content="{{ $category->getKey() }}" class="categoryUpdateButton btn-ghost tooltip tooltip-right" data-tip="Edit this category" />
                                </x-table.cell>
                            @endcan
                            <x-table.cell>
                                {{ $category->getKey() }}
                            </x-table.cell>
                            <x-table.cell>
                                <a class="link link-hover link-primary font-bold" href="{{ $category->show_url }}">
                                    {{ $category->title }}
                                </a>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $category->description }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $category->blog_article_count }}
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $category->created_at->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="8">
                                <div class="text-center p-2">
                                    <span class="text-muted">No categories found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="grid grid-cols-1">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</div>

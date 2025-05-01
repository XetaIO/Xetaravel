<div>
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                @can('search', \Spatie\Permission\Models\Permission::class)
                    {{-- Search input --}}
                    <div class="w-full lg:w-auto md:min-w-[300px]">
                        <x-input icon="fas-search" wire:model.live.debounce="search" placeholder="Search Permissions..." class="lg:max-w-lg" />
                    </div>
                @endcan
                {{-- Create/Delete buttons --}}
                <div class="flex flex-col md:flex-row gap-2">
                    @if($selected?->isNotEmpty())
                        <x-button icon="fas-trash" type="button" label="Delete Permissions" class="btn btn-error" wire:click="deleteSelected" spinner />
                    @endif
                    @can('create', \Spatie\Permission\Models\Permission::class)
                        <x-button icon="fas-plus" type="button" label="New Permission" class="btn btn-success permissionCreateButton" spinner />
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
                    <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created at</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row wire:key="row-message">
                            <x-table.cell colspan="6">
                                @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $permissions->count() }}</strong> permission(s), do you want to select all <strong>{{ $permissions->total() }}</strong> permissions?</span>
                                        <x-button type="button" icon="fas-check" label="Select all" wire:click='setSelectAll' class="btn-sm" spinner />
                                    </div>
                                @else
                                    <span>You have selected actually <strong>{{ $permissions->total() }}</strong> permissions.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse($permissions as $permission)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $permission->getKey() }}">
                            @can('delete', $permission)
                                <x-table.cell>
                                    <label>
                                        <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $permission->getKey() }}" />
                                    </label>
                                </x-table.cell>
                            @endcan
                            @can('update', $permission)
                                <x-table.cell>
                                    <x-button icon="fas-pen-to-square" data-content="{{ $permission->getKey() }}" class="permissionUpdateButton btn-ghost tooltip tooltip-right" data-tip="Edit this permission" />
                                </x-table.cell>
                            @endcan
                            <x-table.cell>
                                {{ $permission->getKey() }}
                            </x-table.cell>
                            <x-table.cell class="prose">
                                <code>{{ $permission->name }}</code>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $permission->description }}
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $permission->created_at->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6">
                                <div class="text-center p-2">
                                    <span class="text-muted">No permissions found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="grid grid-cols-1">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>

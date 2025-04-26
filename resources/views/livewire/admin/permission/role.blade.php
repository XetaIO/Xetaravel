<div>
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                @can('search', \Spatie\Permission\Models\Role::class)
                    {{-- Search input --}}
                    <div class="w-full lg:w-auto md:min-w-[300px]">
                        <x-input icon="fas-search" wire:model.live.debounce="search" placeholder="Search Roles..." class="lg:max-w-lg" />
                    </div>
                @endcan
                {{-- Create/Delete buttons --}}
                <div class="flex flex-col md:flex-row gap-2">
                    @if($selected?->isNotEmpty())
                        <x-button icon="fas-trash" type="button" label="Delete Roles" class="btn btn-error" wire:click="deleteSelected" spinner />
                    @endif
                    @can('create', \Spatie\Permission\Models\Role::class)
                        <x-button icon="fas-plus" type="button" label="New Role" class="btn btn-success roleCreateButton" spinner />
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
                    <x-table.heading sortable wire:click="sortBy('level')" :direction="$sortField === 'level' ? $sortDirection : null">Level</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created at</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row wire:key="row-message">
                            <x-table.cell colspan="6">
                                @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $roles->count() }}</strong> role(s), do you want to select all <strong>{{ $roles->total() }}</strong> roles?</span>
                                        <x-button type="button" icon="fas-check" label="Select all" wire:click='setSelectAll' class="btn-sm" spinner />
                                    </div>
                                @else
                                    <span>You have selected actually <strong>{{ $roles->total() }}</strong> roles.</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse($roles as $role)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $role->getKey() }}">
                            @can('delete', $role)
                                <x-table.cell>
                                    <label>
                                        <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $role->getKey() }}" />
                                    </label>
                                </x-table.cell>
                            @endcan
                            @can('update', $role)
                                <x-table.cell>
                                    <x-button icon="fas-pen-to-square" data-content="{{ $role->getKey() }}" class="roleUpdateButton btn-ghost tooltip tooltip-right" data-tip="Edit this role" />
                                </x-table.cell>
                            @endcan
                            <x-table.cell>
                                {{ $role->getKey() }}
                            </x-table.cell>
                            <x-table.cell>
                                <span class="font-bold" style="color:{{ $role->color }}">
                                    {{ $role->name }}
                                </span>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $role->description }}
                            </x-table.cell>
                            <x-table.cell>
                                {{ $role->level }}
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $role->created_at->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="6">
                                <div class="text-center p-2">
                                    <span class="text-muted">No roles found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="grid grid-cols-1">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>

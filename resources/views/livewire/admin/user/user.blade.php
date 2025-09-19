<div>
    <div class="grid grid-cols-12 gap-6 mb-7">
        <div class="col-span-12 bg-base-100 dark:bg-base-300 shadow-md rounded-lg p-5">
            <div class="flex flex-col lg:flex-row gap-4 justify-between">
                {{-- Search input --}}
                <div class="w-full lg:w-auto md:min-w-[300px]">
                    <x-form.input icon="fas-search" wire:model.live.debounce="search" placeholder="Search Users..." class="lg:max-w-lg" />
                </div>
                {{-- Delete buttons --}}
                <div class="flex flex-col md:flex-row gap-2">
                    @if($selected?->isNotEmpty())
                        <x-button icon="fas-trash" type="button" label="Delete User(s)" class="btn btn-error" wire:click="deleteSelected" spinner />
                    @endif
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
                    <x-table.heading sortable wire:click="sortBy('username')" :direction="$sortField === 'username' ? $sortDirection : null">Username</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('email')" :direction="$sortField === 'email' ? $sortDirection : null">Email</x-table.heading>
                    <x-table.heading>Roles</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('last_login_date')" :direction="$sortField === 'last_login_date' ? $sortDirection : null">Last Login</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('last_login_ip')" :direction="$sortField === 'last_login_ip' ? $sortDirection : null">Last Login IP</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Registered At</x-table.heading>
                    <x-table.heading>Is Deleted</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    @if ($selectPage)
                        <x-table.row wire:key="row-message">
                            <x-table.cell colspan="10">
                                @unless ($selectAll)
                                    <div>
                                        <span>You have selected <strong>{{ $users->count() }}</strong> user(s), do you want to select all <strong>{{ $users->total() }}</strong> user(s)?</span>
                                        <x-button type="button" icon="fas-check" label="Select all" wire:click='setSelectAll' class="btn-sm" spinner />
                                    </div>
                                @else
                                    <span>You have selected actually <strong>{{ $users->total() }}</strong> user(s).</span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @endif

                    @forelse($users as $user)
                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->getKey() }}">
                            @can('delete', $user)
                                <x-table.cell>
                                    <label>
                                        <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $user->getKey() }}" />
                                    </label>
                                </x-table.cell>
                            @endcan
                            @can('update', $user)
                                <x-table.cell>
                                    <x-button icon="fas-pen-to-square" data-content="{{ $user->getKey() }}" class="userUpdateButton btn-ghost tooltip tooltip-right" data-tip="Edit this user" />
                                </x-table.cell>
                            @endcan
                            <x-table.cell>
                                {{ $user->getKey() }}
                            </x-table.cell>
                            <x-table.cell>
                                <div class="flex items-center space-x-3">
                                    <div class="tooltip" data-tip="{{ $user->username }} is {{ $user->online ? 'online' : 'offline' }}" >
                                        <div class="avatar {{ $user->online ? 'avatar-online' : 'avatar-offline' }}">
                                            <div class="mask mask-squircle w-12 h-12 {{ $user->online ? 'tooltip' : '' }}">
                                                <img src="{{ $user->avatar_small }}" alt="{{ $user->full_name }}'s avatar"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <a class="link link-hover link-primary font-bold" href="{{ $user->show_url }}">
                                            {{ $user->full_name }}
                                        </a>
                                    </div>
                                </div>
                            </x-table.cell>
                            <x-table.cell>
                                {{ $user->email }}
                            </x-table.cell>
                            <x-table.cell>
                                @foreach ($user->roles as $role)
                                    <span class="block font-bold" style="color:{{ $role->color }};">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $user->last_login_date?->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $user->last_login_ip }}
                            </x-table.cell>
                            <x-table.cell class="capitalize">
                                {{ $user->created_at->translatedFormat( 'D j M Y H:i') }}
                            </x-table.cell>
                            <x-table.cell>
                                @if ($user->deleted_at)
                                    <span class="text-error font-bold tooltip tooltip-top" datat-tip="Deleted at {{ $user->deleted_at }}">
                                        Yes
                                    </span>
                                @else
                                    <span class="text-success font-bold">
                                        No
                                    </span>
                                @endif
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="10">
                                <div class="text-center p-2">
                                    <span class="text-muted">No users found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>
            </x-table.table>

            <div class="grid grid-cols-1">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

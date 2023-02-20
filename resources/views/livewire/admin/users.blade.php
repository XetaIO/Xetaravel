<div>
    <div class="flex flex-col lg:flex-row gap-6 justify-between">
        <div class="mb-4 w-full lg:w-auto lg:min-w-[350px]">
            <x-form.text wire:model="search" placeholder="Search Users..." class="lg:max-w-lg" />
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('username')" :direction="$sortField === 'username' ? $sortDirection : null">Username</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('email')" :direction="$sortField === 'email' ? $sortDirection : null">Email</x-table.heading>
            <x-table.heading>Roles</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('last_login')" :direction="$sortField === 'last_login' ? $sortDirection : null">Last Login</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('last_login_ip')" :direction="$sortField === 'last_login_ip' ? $sortDirection : null">Last login IP</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Registered At</x-table.heading>
            <x-table.heading>Actions</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @forelse($users as $user)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->getKey() }}">
                    <x-table.cell>{{ $user->getKey() }}</x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary" href="{{ $user->profile_url }}">
                            {{ $user->username }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>{{ $user->email }}</x-table.cell>
                    <x-table.cell>
                        @forelse ($user->roles as $role)
                            <span style="{{ $role->css }}">
                                {{ $role->name }}
                            </span>
                            <br />
                        @empty
                            This user does not have a role.
                        @endforelse
                    </x-table.cell>
                    <x-table.cell>{{ $user->last_login->formatLocalized('%d %B %Y - %T') }}</x-table.cell>
                    <x-table.cell>{{ $user->last_login_ip }}</x-table.cell>
                    <x-table.cell>{{ $user->created_at->formatLocalized('%d %B %Y - %T') }}</x-table.cell>
                    <x-table.cell>
                        <a href="{{ route('admin.user.user.edit', ['slug' => $user->slug, 'id' => $user->getKey()]) }}" class="tooltip" data-tip="Edit this user">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="8">
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

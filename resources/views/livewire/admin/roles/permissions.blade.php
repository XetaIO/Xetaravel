<div>
    @push('scripts')
        <script type="text/javascript">
            Livewire.on('alert', () => {
                document.querySelectorAll('[data-dismiss-target]').forEach(triggerEl => {
                    const targetEl = document.querySelector(triggerEl.getAttribute('data-dismiss-target'))

                    new Dismiss(targetEl, {
                        triggerEl
                    })
                });
            });
        </script>
    @endpush
    @include('elements.flash')

    <div class="flex flex-col lg:flex-row gap-6 justify-between">
        <div class="mb-4 w-full lg:w-auto lg:min-w-[350px]">
            <x-form.text wire:model="search" placeholder="Search Permissions..." class="lg:max-w-lg" />
        </div>
        <div class="mb-4">
            <div class="dropdown lg:dropdown-end">
            <label tabindex="0" class="btn m-1">
                Bulk Actions
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
            </label>
            <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <button type="button" class="text-red-500" wire:click="$toggle('showDeleteModal')">
                        <i class="fa-solid fa-trash-can"></i> Delete
                    </button>
                </li>
            </ul>
        </div>
            <a href="#" wire:click.prevent="create" class="btn gap-2">
                <i class="fa-solid fa-plus"></i>
                New Permission
            </a>
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            <x-table.heading>
                <label>
                    <input type="checkbox" class="checkbox" wire:model="selectPage" />
                </label>
            </x-table.heading>
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('slug')" :direction="$sortField === 'slug' ? $sortDirection : null">Slug</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_deletable')" :direction="$sortField === 'is_deletable' ? $sortDirection : null">Deletable</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-table.heading>
            <x-table.heading>Actions</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @if ($selectPage)
            <x-table.row class="bg-cool-gray-200" wire:key="row-message" >
                <x-table.cell colspan="7">
                    @unless ($selectAll)
                    <div>
                        <span>You have selected <strong>{{ $permissions->count() }}</strong> permissions, do you want to select all <strong>{{ $permissions->count() }}</strong>?</span>
                        <button type="button" wire:click="selectAll" class="btn btn-sm gap-2 ml-1">
                            <i class="fa-solid fa-check"></i>
                            Select All
                        </button>
                    </div>
                    @else
                    <span>You are currently selecting all <strong>{{ $permissions->total() }}</strong> permissions.</span>
                    @endif
                </x-table.cell>
            </x-table.row>
            @endif

            @forelse($permissions as $permission)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $permission->getKey() }}">
                    <x-table.cell>
                        <label>
                            <input type="checkbox" class="checkbox" wire:model="selected" value="{{ $permission->getKey() }}" />
                        </label>
                    </x-table.cell>
                    <x-table.cell>{{ $permission->getKey() }}</x-table.cell>
                    <x-table.cell>{{ $permission->name }}</x-table.cell>
                    <x-table.cell class="prose"><code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">{{ $permission->slug }}</code></x-table.cell>
                    <x-table.cell>{{ $permission->description }}</x-table.cell>
                    <x-table.cell>
                        @if ($permission->is_deletable)
                            <span class="font-bold text-red-500">Yes</span>
                        @else
                            <span class="font-bold text-green-500">No</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>{{ $permission->created_at->formatLocalized('%d %B %Y - %T') }}</x-table.cell>
                    <x-table.cell>
                        <a href="#" wire:click.prevent="edit({{ $permission->getKey() }})" class="tooltip" data-tip="Edit this permission">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="9">
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


    <!-- Delete Permissions Modal -->
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Delete Permissions
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        You have not selected any permission to delete.
                    </p>
                @else
                    <p class="my-7">
                        Are you sure you want to delete those Permissions ? <span class="font-bold text-red-500">This operation is not reversible.</span>
                    </p>
                @endif
                <div class="modal-action">
                    <button type="submit" class="btn btn-error gap-2" @if (empty($selected)) disabled @endif>
                        <i class="fa-solid fa-trash-can"></i>
                        Delete
                    </button>
                    <label for="deleteModal" class="btn">Close</label>
                </div>
            </label>
        </label>
    </form>

    <!-- Edit Permission Modal -->
    <form wire:submit.prevent="save">
        <input type="checkbox" id="editModal" class="modal-toggle" wire:model="showModal" />
        <label for="editModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    {!! $isCreating ? 'Create Permission' : 'Edit Permission' !!}
                </h3>

                <x-form.text wire:model="model.name" wire:keyup='generateSlug' id="name" name="model.name" label="Name" placeholder="Name..." />

                <x-form.text wire:model="model.slug" id="slug" name="model.slug" label="Slug" disabled />

                <x-form.textarea wire:model="model.description" name="model.description" label="Description" placeholder="Description..." />

                <x-form.checkbox wire:model="model.is_deletable" name="is_deletable" label="Deletable">
                    Check to make this permission deletable
                </x-form.checkbox>

                <div class="modal-action">
                    <button type="submit" class="btn gap-2">
                        {!! $isCreating ? '<i class="fa-solid fa-plus"></i> Create' : '<i class="fa-solid fa-pen-to-square"></i> Edit' !!}
                    </button>
                    <label for="editModal" class="btn">Close</label>
                </div>
            </label>
        </label>
    </form>

</div>

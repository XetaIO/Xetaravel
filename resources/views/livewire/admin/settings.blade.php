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
            <x-form.text wire:model="search" placeholder="Search Settings..." class="lg:max-w-lg" />
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
                New Setting
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
            <x-table.heading>Value</x-table.heading>
            <x-table.heading>Type</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_deletable')" :direction="$sortField === 'is_deletable' ? $sortDirection : null">Deletable</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Created At</x-table.heading>
            <x-table.heading>Actions</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @if ($selectPage)
            <x-table.row class="bg-cool-gray-200" wire:key="row-message" >
                <x-table.cell colspan="9">
                    @unless ($selectAll)
                    <div>
                        <span>You have selected <strong>{{ $settings->count() }}</strong> settings, do you want to select all <strong>{{ $settings->count() }}</strong>?</span>
                        <button type="button" wire:click="selectAll" class="btn btn-sm gap-2 ml-1">
                            <i class="fa-solid fa-check"></i>
                            Select All
                        </button>
                    </div>
                    @else
                    <span>You are currently selecting all <strong>{{ $settings->total() }}</strong> settings.</span>
                    @endif
                </x-table.cell>
            </x-table.row>
            @endif

            @forelse($settings as $setting)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $setting->getKey() }}">
                    <x-table.cell>
                        <label>
                            <input type="checkbox" class="checkbox" wire:model="selected" value="{{ $setting->getKey() }}" />
                        </label>
                    </x-table.cell>
                    <x-table.cell>{{ $setting->getKey() }}</x-table.cell>
                    <x-table.cell class="prose"><code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">{{ $setting->name }}</code></x-table.cell>
                    <x-table.cell class="prose">
                        <code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            @if ($setting->type == "value_bool")
                                @if ($setting->value == false)
                                    false
                                @else
                                    true
                                @endif
                            @else
                                {{ (string)$setting->value }}
                            @endif
                        </code>
                    </x-table.cell>
                    <x-table.cell class="prose">
                        <code class="text-[color:hsl(var(--p))] bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            @if ($setting->type == "value_bool")
                                boolean
                            @elseif ($setting->type == "value_int")
                                integer
                            @else
                                string
                            @endif
                        </code>
                    </x-table.cell>
                    <x-table.cell>{{ $setting->description }}</x-table.cell>
                    <x-table.cell>
                        @if ($setting->is_deletable)
                            <span class="font-bold text-red-500">Yes</span>
                        @else
                            <span class="font-bold text-green-500">No</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>{{ $setting->created_at->formatLocalized('%d %B %Y - %T') }}</x-table.cell>
                    <x-table.cell>
                        <a href="#" wire:click.prevent="edit({{ $setting->getKey() }})" class="tooltip" data-tip="Edit this setting">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="9">
                        <div class="text-center p-2">
                            <span class="text-muted">No settings found...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $settings->links() }}
    </div>


    <!-- Delete Settings Modal -->
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Delete Settings
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        You have not selected any setting to delete.
                    </p>
                @else
                    <p class="my-7">
                        Are you sure you want to delete those Settings ? <span class="font-bold text-red-500">This operation is not reversible.</span>
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

    <!-- Edit Setting Modal -->
    <form wire:submit.prevent="save">
        <input type="checkbox" id="editModal" class="modal-toggle" wire:model="showModal" />
        <label for="editModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    {!! $isCreating ? 'Create Setting' : 'Edit Setting' !!}
                </h3>

                <x-form.text wire:model="model.name" wire:keyup='generateName' name="model.name" label="Name" placeholder="Name..." />

                <x-form.text wire:model="slug" id="slug" name="slug" label="Slug" disabled />

                <x-form.text wire:model="value" id="value" name="value" label="Value" placeholder="Value..." />

                <div class="form-control w-full max-w-xs">
                        <label class="label" for="type">
                            <span class="label-text">Type</span>
                        </label>
                </div>

                @foreach (\Xetaravel\Models\Setting::TYPES as $key => $value)
                    <x-form.radio wire:model="type" value="{{ $key }}" name="type">
                        {{ $value }}
                    </x-form.radio>
                @endforeach

                <x-form.textarea wire:model="model.description" name="model.description" label="Description" placeholder="Description..." />

                <x-form.checkbox wire:model="model.is_deletable" name="is_deletable" label="Deletable">
                    Check to make this setting deletable
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

<div>
    <div class="mb-5">
        <x-button wire:click="create" icon="fas-pencil" label="Start a Discussion" class="btn-primary gap-2" />
    </div>

    <x-modal wire:model="showModal" title="Create a Discussion" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-input wire:model="form.title" name="form.title" label="Title" placeholder="Discussion title..." />

        <x-choices
            label="Category"
            wire:model="form.category_id"
            :options="$form->categoriesSearchable"
            option-sub-label="description"
            search-function="searchCategories"
            no-result-text="No result..."
            debounce="300ms"
            min-chars="2"
            single
            searchable>

            {{-- Item slot--}}
            @scope('item', $option)
            <x-list-item :item="$option">
                <x-slot:avatar>
                    <x-icon :name="$option->icon" class="bg-primary/30 p-2 w-8 h-8 rounded-full" />
                </x-slot:avatar>

                <x-slot:value>
                    <span style="color:{{ $option->color }};">{{ $option->title }}</span>
                </x-slot:value>

                <x-slot:sub-value>
                    {{ $option->description }}
                </x-slot:sub-value>

            </x-list-item>
            @endscope

            {{-- Selection slot--}}
            @scope('selection', $option)
                <x-icon :name="$option->icon" class="h-4 w-4 inline" style="color:{{ $option->color }};" />
                <span style="color:{{ $option->color }};">{{ $option->title }}</span>
            @endscope
        </x-choices>

        @php
            $config = [
                'sideBySideFullscreen' => false,
                'maxHeight' => '200px'
            ];
        @endphp

        <x-markdown :config="$config" wire:model="form.content" name="form.content" label="Content" placeholder="Your message here..." />

        @canany(['pin', 'lock'], \Xetaravel\Models\DiscussConversation::class)
            <div class="text-sm">
                Moderation
            </div>
            @can('pin', \Xetaravel\Models\DiscussConversation::class)
                <x-checkbox wire:model="form.is_pinned" name="form.is_pinned" label="Check to pin this discussion" />
            @endcan

            @can('lock', \Xetaravel\Models\DiscussConversation::class)
                <x-checkbox wire:model="form.is_locked" name="form.is_locked" label="Check to lock this discussion" />
            @endcan
        @endcanany

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Create" icon="fas-pencil" type="button" wire:click="save" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Fermer" />
        </x-slot:actions>
    </x-modal>
</div>

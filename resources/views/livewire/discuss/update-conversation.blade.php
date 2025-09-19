<div>
    <x-modal wire:model="showModal" title="Update this discussion" class="backdrop-blur">

        <x-form.input wire:model="form.title" name="form.title" label="Title" placeholder="Discussion title..." />

        <x-form.choices
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
        </x-form.choices>

        @canany(['pin', 'lock'], \Xetaravel\Models\DiscussConversation::class)
            <div class="text-sm">
                Moderation
            </div>
            @can('pin', \Xetaravel\Models\DiscussConversation::class)
                <x-form.checkbox wire:model="form.is_pinned" name="form.is_pinned" text="Check to pin this discussion" />
            @endcan

            @can('lock', \Xetaravel\Models\DiscussConversation::class)
                <x-form.checkbox wire:model="form.is_locked" name="form.is_locked" text="Check to lock this discussion" />
            @endcan
        @endcanany

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Discuss conversation Update Button
            const conversationUpdateButton = document.getElementsByClassName('conversationUpdateButton');
            Array.from(conversationUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    $wire.dispatch('update-conversation');
                }, false);
            });
        });
    </script>
    @endscript
</div>

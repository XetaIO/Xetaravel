<div>
    <x-modal wire:model="showModal" title="Create an Article" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-file wire:model="form.banner" label="Article Banner" hint="Recommended size: 870x350px" accept="image/png, image/jpeg">
            <img src="{{ asset('images/articles/default_banner.jpg') }}" class="h-40 rounded-lg ring-2 ring-base-content ring-offset-base-100 ring-offset-2"  alt="Default banner" />
        </x-file>

        <x-input wire:model="form.title" name="form.title" label="Title" placeholder="Discussion title..." />

        <x-choices
            label="Category"
            wire:model="form.blog_category_id"
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
                    <x-icon name="fas-tags" class="bg-primary/30 p-2 w-8 h-8 rounded-full" />
                </x-slot:avatar>

                <x-slot:value>
                    {{ $option->title }}
                </x-slot:value>

                <x-slot:sub-value>
                    {{ $option->description }}
                </x-slot:sub-value>
            </x-list-item>
            @endscope

            {{-- Selection slot--}}
            @scope('selection', $option)
                <x-icon name="fas-tags" class="h-4 w-4 inline" />
                {{ $option->title }}
            @endscope
        </x-choices>

        <x-date-picker label="Published date" wire:model="form.published_at" icon="far-calendar" hint="This article will be published at this date & time." />

        @php
            $config = [
                'sideBySideFullscreen' => false,
                'maxHeight' => '500px'
            ];
        @endphp

        <x-markdown :config="$config" wire:model="form.content" name="form.content" label="Content" placeholder="Your message here..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Create" icon="fas-pencil" type="button" wire:click="create" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Blog article Create Button
            const articleCreateButton = document.getElementsByClassName('articleCreateButton');
            Array.from(articleCreateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    $wire.dispatch('create-article');
                }, false);
            });
        });
    </script>
    @endscript
</div>

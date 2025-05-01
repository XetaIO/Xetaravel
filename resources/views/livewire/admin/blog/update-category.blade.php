<div>
    <x-modal wire:model="showModal" title="Update a Category" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-input wire:model="form.title" name="form.title" label="Title" placeholder="Category title..." />

        <x-textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Category description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Blog category Update Button
            const categoryUpdateButton = document.getElementsByClassName('categoryUpdateButton');
            Array.from(categoryUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-category', { blogCategory: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

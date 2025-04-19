<div>
    <x-modal wire:model="showModal" title="Create a Category" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-input wire:model="form.title" name="form.title" label="Title" placeholder="Category title..." />

        <x-textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Category description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Create" icon="fas-pencil" type="button" wire:click="create" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Blog category Create Button
            const categoryCreateButton = document.getElementsByClassName('categoryCreateButton');
            Array.from(categoryCreateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    $wire.dispatch('create-category');
                }, false);
            });
        });
    </script>
    @endscript
</div>

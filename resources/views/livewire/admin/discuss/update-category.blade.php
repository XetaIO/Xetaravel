<div>
    <x-modal wire:model="showModal" title="Update a Category" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-form.input wire:model="form.title" name="form.title" label="Title" placeholder="Category title..." />

        <x-form.color-picker wire:model="form.color" label="Color" icon="fas-swatchbook" placeholder="#FF00FF" />

        <x-form.input wire:model="form.level" name="form.level" label="Level" type="number" />

        <x-form.input wire:model="form.icon" name="form.icon" label="Icon" placeholder="fas-search..." />

        <x-form.checkbox wire:model="form.is_locked" name="form.is_locked" label="Locked" text="Check to lock this category" hint="Only users with manage permission can create discussions in locked categories" />

        <x-form.textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Category description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Discuss category Update Button
            const categoryUpdateButton = document.getElementsByClassName('categoryUpdateButton');
            Array.from(categoryUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-category', { discussCategory: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

<div>
    <x-modal wire:model="showModal" title="Create a Role" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-input wire:model="form.name" name="form.name" label="Name" placeholder="Role title..." />

        <x-color-picker wire:model="form.color" label="Color" icon="fas-swatchbook" placeholder="#FF00FF" />

        <x-input wire:model="form.level" name="form.level" label="Level" type="number" />

        <x-select
            class="min-h-[150px]"
            :options="$permissions"
            wire:model="form.permissions"
            name="form.permissions"
            label="Permissions"
            option-label="name"
            option-value="name"
            multiple
        />

        <x-textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Role description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Create" icon="fas-pencil" type="button" wire:click="create" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Role Create Button
            const roleCreateButton = document.getElementsByClassName('roleCreateButton');
            Array.from(roleCreateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    $wire.dispatch('create-role');
                }, false);
            });
        });
    </script>
    @endscript
</div>

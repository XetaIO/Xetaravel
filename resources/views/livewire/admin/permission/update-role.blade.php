<div>
    <x-modal wire:model="showModal" title="Update a Role" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-form.input wire:model="form.name" name="form.name" label="Name" placeholder="Role title..." />

        <x-form.color-picker wire:model="form.color" label="Color" icon="fas-swatchbook" placeholder="#FF00FF" />

        <x-form.input wire:model="form.level" name="form.level" label="Level" type="number" />

        <x-form.select
            class="min-h-[150px]"
            :options="$permissions"
            wire:model="form.permissions"
            name="form.permissions"
            label="Permissions"
            option-label="name"
            option-value="name"
            multiple
        />

        <x-form.textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Role description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Role Update Button
            const roleUpdateButton = document.getElementsByClassName('roleUpdateButton');
            Array.from(roleUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-role', { role: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

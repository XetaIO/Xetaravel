<div>
    <x-modal wire:model="showModal" title="Update a Permission" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-form.input wire:model="form.name" name="form.name" label="Name" placeholder="Permission title..." />

        <x-form.textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Permission description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Permission Update Button
            const permissionUpdateButton = document.getElementsByClassName('permissionUpdateButton');
            Array.from(permissionUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-permission', { permission: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

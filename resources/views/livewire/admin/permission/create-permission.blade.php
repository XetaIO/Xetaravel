<div>
    <x-modal wire:model="showModal" title="Create a Permission" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-form.input wire:model="form.name" name="form.name" label="Name" placeholder="Permission title..." />

        <x-form.textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Permission description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Create" icon="fas-pencil" type="button" wire:click="create" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Permission Create Button
            const permissionCreateButton = document.getElementsByClassName('permissionCreateButton');
            Array.from(permissionCreateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    $wire.dispatch('create-permission');
                }, false);
            });
        });
    </script>
    @endscript
</div>

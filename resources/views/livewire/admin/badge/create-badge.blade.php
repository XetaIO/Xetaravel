<div>
    <x-modal wire:model="showModal" title="Create a Badge" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-form.input wire:model="form.name" name="form.name" label="Name" placeholder="Badge title..." />

        <x-form.input wire:model="form.icon" name="form.icon" label="Icon" />

        <x-form.color-picker wire:model="form.color" label="Color" icon="fas-swatchbook" placeholder="#FF00FF" />

        <x-form.input wire:model="form.type" name="form.type" label="Type" />

        <x-form.input wire:model="form.rule" name="form.rule" label="Rule" type="number" />

        <x-form.textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Badge description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Create" icon="fas-pencil" type="button" wire:click="create" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Badge Create Button
            const badgeCreateButton = document.getElementsByClassName('badgeCreateButton');
            Array.from(badgeCreateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    $wire.dispatch('create-badge');
                }, false);
            });
        });
    </script>
    @endscript
</div>

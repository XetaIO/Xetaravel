<div>
    <x-modal wire:model="showModal" title="Update a Badge" class="backdrop-blur" box-class="w-11/12 max-w-5xl">

        <x-input wire:model="form.name" name="form.name" label="Name" placeholder="Badge title..." />

        <x-input wire:model="form.icon" name="form.icon" label="Icon" />

        <x-color-picker wire:model="form.color" label="Color" icon="fas-swatchbook" placeholder="#FF00FF" />

        <x-input wire:model="form.type" name="form.type" label="Type" />

        <x-input wire:model="form.rule" name="form.rule" label="Rule" type="number" />

        <x-textarea wire:model="form.description" name="form.description" label="Description"  placeholder="Badge description..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Badge Update Button
            const badgeUpdateButton = document.getElementsByClassName('badgeUpdateButton');
            Array.from(badgeUpdateButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-badge', { badge: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

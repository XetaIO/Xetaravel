<div>
    <x-modal wire:model="showModal" title="Edit a Post" class="backdrop-blur" box-class="w-11/12 max-w-5xl">
        @php
            $config = [
                'sideBySideFullscreen' => false,
                'maxHeight' => '200px'
            ];
        @endphp

        <x-markdown :config="$config" wire:model="form.content" name="form.content" label="Content" placeholder="Your message here..." />

        <x-slot:actions>
            <x-button class="btn-success gap-2" label="Update" icon="fas-pencil" type="button" wire:click="update" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Fermer" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Discuss conversation post Reply Button
            const postEditButton = document.getElementsByClassName('postEditButton');
            Array.from(postEditButton).forEach(function (button) {
                button.addEventListener('click', function (event) {

                    let id = button.getAttribute("data-content");

                    $wire.dispatch('update-post', { discussPost: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

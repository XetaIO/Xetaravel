<div>
    <x-modal wire:model="showModal" title="Delete this post" class="backdrop-blur">
        <p class="my-7">
            Do you really want to delete this post ? <span class="font-bold text-red-500">This operation is not reversible.</span>
        </p>

        <x-slot:actions>
            <x-button class="btn-error gap-2" label="Delete" icon="fas-trash-can" type="button" wire:click="delete" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Discuss post Delete Button
            const postDeleteButton = document.getElementsByClassName('postDeleteButton');
            Array.from(postDeleteButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('delete-post', { discussPost: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

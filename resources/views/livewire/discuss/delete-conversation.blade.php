<div>
    <x-modal wire:model="showModal" title="Delete this discussion" class="backdrop-blur">
        <p class="my-7">
            Do you really want to delete this conversation ? <span class="font-bold text-red-500">This operation is not reversible.</span>
        </p>

        <x-slot:actions>
            <x-button class="btn-error gap-2" label="Delete" icon="fas-trash-can" type="button" wire:click="delete" spinner />
            <x-button @click="$wire.showModal = false" class="btn-neutral" label="Close" />
        </x-slot:actions>
    </x-modal>

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Discuss conversation Delete Button
            const conversationDeleteButton = document.getElementsByClassName('conversationDeleteButton');
            Array.from(conversationDeleteButton).forEach(function (button) {
                button.addEventListener('click', function (event) {
                    let id = button.getAttribute("data-content");

                    $wire.dispatch('delete-conversation', { discussConversation: id });
                }, false);
            });
        });
    </script>
    @endscript
</div>

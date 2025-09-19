<div class="self-start ml-3 mt-3 w-full">
    @php
        $config = [
            'sideBySideFullscreen' => false
        ];
    @endphp
    <x-form.markdown :config="$config" wire:model="form.content" name="form.content" label="Content" placeholder="Your message here..." />

    @canany(['pin', 'lock'], \Xetaravel\Models\DiscussConversation::class)
        <div class="text-sm">
            Moderation
        </div>
        @can('pin', \Xetaravel\Models\DiscussConversation::class)
            <x-form.checkbox wire:model="form.is_pinned" name="form.is_pinned" text="Check to pin this discussion" />
        @endcan

        @can('lock', \Xetaravel\Models\DiscussConversation::class)
            <x-form.checkbox wire:model="form.is_locked" name="form.is_locked" text="Check to lock this discussion" />
        @endcan
    @endcanany

    <x-button class="btn-primary gap-2" label="Reply" icon="fas-pencil" type="button" wire:click="create" spinner />

    @script
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            // Discuss conversation post Reply Button
            const postReplyButton = document.getElementsByClassName('postReplyButton');
            Array.from(postReplyButton).forEach(function (button) {
                button.addEventListener('click', function (event) {

                    let content = button.getAttribute("data-content");

                    $wire.dispatch('post-reply', { content: content + '\n' });
                }, false);
            });
        });
    </script>
    @endscript
</div>

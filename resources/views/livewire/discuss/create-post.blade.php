<div class="self-start ml-3 mt-3 w-full">
    <x-markdown wire:model="form.content" name="form.content" label="Content" placeholder="Your message here..." />

    @can('pin', \Xetaravel\Models\DiscussConversation::class)
        <x-checkbox wire:model="form.is_pinned" name="form.is_pinned" label="Check to pin this discussion" />
    @endcan

    @can('lock', \Xetaravel\Models\DiscussConversation::class)
        <x-checkbox wire:model="form.is_locked" name="form.is_locked" label="Check to lock this discussion" />
    @endcan

    <x-button class="btn-primary gap-2" label="Reply" icon="fas-pencil" type="button" wire:click="create" spinner />
</div>

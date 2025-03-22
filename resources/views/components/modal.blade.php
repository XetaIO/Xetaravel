<dialog
    {{ $attributes->except('wire:model')->class(["modal"]) }}

    @if($id)
        id="{{ $id }}"
    @else
        x-data="{open: @entangle($attributes->wire('model')).live }"
    :class="{'modal-open !animate-none': open}"
    :open="open"
    @if(!$persistent)
        @keydown.escape.window = "$wire.{{ $attributes->wire('model')->value() }} = false"
    @endif
    @endif

    @if(!$withoutTrapFocus)
        x-trap="open" x-bind:inert="!open"
    @endif
>
    <div class="modal-box {{ $boxClass }}">
        @if(!$persistent)
            <form method="dialog" tabindex="-1">
                @if ($id)
                    <x-button class="btn-circle btn-sm btn-ghost absolute end-2 top-2 z-[999]" icon="fas-xmark"  icon-classes="h-4 w-4" type="submit" tabindex="-1" />
                @else
                    <x-button class="btn-circle btn-sm btn-ghost absolute end-2 top-2 z-[999]" icon="fas-xmark"  icon-classes="h-4 w-4" @click="$wire.{{ $attributes->wire('model')->value() }} = false" tabindex="-1" />
                @endif
            </form>
        @endif

        @if($title)
            <x-header :title="$title" :subtitle="$subtitle" size="text-xl" :separator="$separator" class="!mb-5" />
        @endif

        <div>
            {{ $slot }}
        </div>

        @if($separator && $actions)
            <hr class="border-base-content/10 mt-5" />
        @endif

        @if($actions)
            <div class="modal-action">
                {{ $actions }}
            </div>
        @endif
    </div>

    @if(!$persistent)
        <form class="modal-backdrop" method="dialog">
            @if ($id)
                <button type="submit">close</button>
            @else
                <button @click="$wire.{{ $attributes->wire('model')->value() }} = false" type="button">close</button>
            @endif
        </form>
    @endif
</dialog>

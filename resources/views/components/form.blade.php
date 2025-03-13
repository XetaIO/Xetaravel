<form
    {{ $attributes->whereDoesntStartWith('class') }}
    {{ $attributes->class(['grid grid-flow-row auto-rows-min gap-3']) }}
>
    <!-- CSRF -->
    @csrf

    {{ $slot }}

    @if ($actions)
        <hr @class(["invisible", "border-base-300 !my-3 !visible" => !$noSeparator]) />

        <div {{ $actions->attributes->class(["flex justify-end gap-3"]) }}>
            {{ $actions}}
        </div>
    @endif
</form>

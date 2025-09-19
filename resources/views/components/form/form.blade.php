@props(['method' => 'GET'])

@php
    $spoofMethod = '';
    $method = str($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<form
    {{ $attributes->whereDoesntStartWith('class') }}
    {{ $attributes->class(['grid grid-flow-row auto-rows-min gap-3']) }}
    method="{{ $method }}"
>
    <!-- METHOD -->
    @if ($spoofMethod)
        @method($spoofMethod)
    @endif

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

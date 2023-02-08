@props(['method' => 'GET'])

@php
    $spoofMethod = '';
    $method = str($method)->upper();
    if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
        $spoofMethod = $method;
        $method = 'POST';
    }
@endphp

<div>
    <form method="{{ $method }}" {{ $attributes }}>
        @csrf
        @if ($spoofMethod)
            @method($spoofMethod)
        @endif

        {{ $slot }}
    </form>
</div>
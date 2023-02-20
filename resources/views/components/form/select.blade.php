@props([
    'label' => false,
    'name' => '',
    'value' => ''
])

{{-- Required for multiple select --}}
@php
    $errorName = str_replace('[', '', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="form-control">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <select {{ $name ? 'name=' . $name . ' id=' . $name : '' }} {{ $attributes->merge(['class' => $errors->has($errorName) ? 'select select-bordered select-error w-full' : 'select select-bordered w-full']) }} >
        {{ $slot }}
    </select>

    @error($errorName)
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror
</div>

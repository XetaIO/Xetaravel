@props([
    'label' => false,
    'name' => '',
    'value' => ''
])

{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
    $hasError = $errors->has($errorName) || ($errors->has('slug') && in_array($errorName, ['title', 'name'])) ? true : false;
@endphp

<div class="form-control">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <input type="text" {{ $name ? 'name=' . $name . ' id=' . $name : '' }} {{ $attributes->merge(['class' => $hasError ? 'input input-bordered input-error w-full' : 'input input-bordered w-full']) }} value="{{ $value ? $value : old($name) }}" />

    @error($errorName)
        <label class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </label>
    @enderror

    @if ($errors->has('slug') && in_array($errorName, ['title', 'name']))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first('slug') }}</span>
        </label>
    @endif
</div>

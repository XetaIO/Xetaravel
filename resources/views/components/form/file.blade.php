@props([
    'label' => false,
    'name' => '',
    'value' => ''
])

<div class="form-control">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <input type="file" name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => $errors->has($name) ? 'file-input file-input-bordered file-input-error w-full' : 'file-input file-input-bordered w-full']) }} value="{{ $value ? $value : old($name) }}" />

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($name) }}</span>
        </label>
    @endif
</div>

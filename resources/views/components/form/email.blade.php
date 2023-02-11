@props([
    'label' => false,
    'name' => '',
    'value' => ''
])

<div class="form-control">
    @if ($label !== false)
        <label class="label">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <input type="email" name="{{ $name }}" {{ $attributes->merge(['class' => $errors->has($name) ? 'input input-bordered input-error w-full' : 'input input-bordered w-full']) }} value="{{ $value ? $value : old($name) }}" />

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($name) }}</span>
        </label>
    @endif
</div>

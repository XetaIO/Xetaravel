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

    <select {{ $name ? 'name=' . $name . ' id=' . $name : '' }} {{ $attributes->merge(['class' => $errors->has($name) ? 'select select-bordered select-error w-full' : 'select select-bordered w-full']) }} >
        {{ $slot }}
    </select>

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($name) }}</span>
        </label>
    @endif
</div>

@props([
    'label' => false,
    'name' => '',
    'value' => '',
    'type' => 'text'
])

<div class="form-control">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif
    <label class="input-group {!! $attributes->has('data-input-group-verticale') ? $attributes->get('data-input-group-verticale') : ''  !!}">
        <span {!! $attributes->has('data-span-class') ? 'class="' . $attributes->get('data-span-class') .'"' : ''  !!}>
            {{ $slot }}
        </span>

        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => $errors->has($name) ? 'input input-bordered input-error w-full' : 'input input-bordered w-full']) }} value="{{ $value ? $value : old($name) }}" />
    </label>

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($name) }}</span>
        </label>
    @endif
</div>
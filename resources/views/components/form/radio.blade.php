@props([
    'label' => false,
    'name' => ''
])

<div class="form-control w-full max-w-xs">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <label class="cursor-pointer label justify-start">
        <input type="radio" {{ $attributes->merge(['class' => $errors->has($name) ? 'radio radio-error' : 'radio']) }} />
        <span class="label-text ml-2">{{ $slot }}</span>
    </label>

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">
                {{ $errors->first($name) }}
            </span>
        </label>
    @endif
</div>
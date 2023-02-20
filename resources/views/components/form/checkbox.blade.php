@props([
    'label' => false,
    'name' => '',
    'checked' => false
])

<div class="form-control w-full max-w-xs">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    <label class="cursor-pointer label justify-start">
        <input type="checkbox" name="{{ $name }}" {{ $attributes->merge(['class' => $errors->has($name) ? 'checkbox checkbox-error' : 'checkbox']) }} @checked(old($name, $checked)) />
        @if ($label !== false)
            <span class="label-text ml-2">{{ $slot }}</span>
        @endif
    </label>

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">
                {{ $errors->first($name) }}
            </span>
        </label>
    @endif
</div>

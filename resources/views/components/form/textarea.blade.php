@props([
    'label' => false,
    'name' => ''
])

<div class="form-control">
    @if ($label !== false)
        <label class="label" for="{{ $name }}">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif

    @if($attributes->has('editor'))
        <div id="{{ $attributes->get('editor') }}">
    @endif

    <textarea name="{{ $name }}" id="{{ $attributes->has('editor') ? $attributes->get('editor') : $name }}" {{ $attributes->merge(['class' => $errors->has($name) ? 'textarea textarea-bordered textarea-error w-full' : 'textarea textarea-bordered w-full', 'rows' => 5]) }} >{{ empty($slot->toHtml()) ? old($name) : $slot }}</textarea>

    @if($attributes->has('editor'))
        </div>
    @endif

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">
                {{ $errors->first($name) }}
            </span>
        </label>
    @endif
</div>

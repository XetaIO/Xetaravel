<div class="form-control">
    @if ($label !== false)
        <label class="label">
            <span class="label-text {{ $labelClass }}">{{ $label }}</span>
        </label>
    @endif

    @isset($attributes['editor'])
        <div id="{{ $attributes['editor'] }}">
    @endisset

    {!! Form::textarea(
        $name,
        $value,
        array_merge(['class' => $errors->has($name) ? 'textarea textarea-bordered textarea-error' : 'textarea textarea-bordered', 'rows' => 5], $attributes)
    ) !!}

    @isset($attributes['editor'])
        </div>
    @endisset

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">
                {{ $errors->first($name) }}
            </span>
        </label>
    @endif
</div>

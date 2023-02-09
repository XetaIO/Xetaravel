<div class="form-gcontrol w-full max-w-xs">
    <label class="cursor-pointer label justify-start">
        {!! Form::checkbox($name, $value, $checked, array_merge(['class' => $errors->has($name) ? 'checkbox checkbox-error' : 'checkbox'], $attributes)) !!}
        <span class="label-text ml-2 {{ $labelClass }}">{{ $label }}</span>
    </label>

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">
                {{ $errors->first($name) }}
            </span>
        </label>
    @endif
</div>

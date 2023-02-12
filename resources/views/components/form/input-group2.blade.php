{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="form-group {{ $errors->has($errorName) ? 'has-danger' : '' }}">
    @if (!is_null($label))
        {!! Form::label($name, $label) !!}
    @endif

    <div class="input-group">
        <span
            for="{{ $name }}"
            style="{{ isset($attributes['spanStyle']) ? $attributes['spanStyle'] : '' }}"
            class="{{ isset($attributes['spanClass']) ? $attributes['spanClass'] : 'input-group-addon' }}">
            {!! isset($attributes['span']) ? $attributes['span'] : $label !!}
        </span>
        @if (isset($attributes['type']) && $attributes['type'] == 'password')
            {!! Form::password(
                $name,
                array_merge(['class' => $errors->has($errorName) ? 'form-control form-control-danger' : 'form-control'], $attributes)
            ) !!}
        @else
            {!! Form::text(
                $name,
                $value,
                array_merge(['class' => $errors->has($errorName) ? 'form-control form-control-danger' : 'form-control'], $attributes)
            ) !!}
        @endif
    </div>

    @if ($errors->has($errorName))
        <div class="form-control-feedback">
            {{ $errors->first($errorName) }}
        </div>
    @endif
</div>

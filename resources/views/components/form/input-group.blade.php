<div class="form-group">
    @if (!is_null($label))
        {!! Form::label($name, $label) !!}
    @endif

    <div class="input-group {{ $errors->has($name) ? 'has-danger' : '' }}">
        <span for="{{ $name }}" style="{{ isset($attributes['spanStyle']) ? $attributes['spanStyle'] : '' }}" class="input-group-addon">{!! isset($attributes['span']) ? $attributes['span'] : $label !!}</span>
        @if (isset($attributes['type']) && $attributes['type'] == 'password')
            {!! Form::password(
                $name,
                array_merge(['class' => $errors->has($name) ? 'form-control form-control-danger' : 'form-control'], $attributes)
            ) !!}
        @else
            {!! Form::text(
                $name,
                $value,
                array_merge(['class' => $errors->has($name) ? 'form-control form-control-danger' : 'form-control'], $attributes)
            ) !!}
        @endif

        @if ($errors->has($name))
            <div class="form-control-feedback">
                {{ $errors->first($name) }}
            </div>
        @endif
    </div>
</div>

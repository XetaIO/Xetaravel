<div class="form-group">
    {!! Form::label($name, $label) !!}
    
    <div class="input-group {{ $errors->has($name) ? 'has-danger' : '' }}">
        <span for="{{ $name }}" style="{{ isset($attributes['spanStyle']) ? $attributes['spanStyle'] : '' }}" class="input-group-addon">{{ isset($attributes['span']) ? $attributes['span'] : $label }}</span>
        {!! Form::text(
            $name,
            $value,
            array_merge(['class' => $errors->has($name) ? 'form-control form-control-danger' : 'form-control'], $attributes)
        ) !!}
        @if ($errors->has($name))
            <div class="form-control-feedback">
                {{ $errors->first($name) }}
            </div>
        @endif
    </div>
</div>

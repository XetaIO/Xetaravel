<div class="form-group {{ $errors->has($name) || $errors->has('slug') ? 'has-danger' : '' }}">
    @if ($label !== false)
        {!! Form::label($name, $label, ['class' => $labelClass]) !!}
    @endif

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

    @if ($errors->has('slug'))
        <div class="form-control-feedback">
            {{ $errors->first('slug') }}
        </div>
    @endif
</div>

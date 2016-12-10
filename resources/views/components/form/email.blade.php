<div class="form-group {{ $errors->has($name) ? 'has-danger' : '' }}">
    {!! Form::label($name, $label, ['class' => 'form-control-label']) !!}
    {!! Form::email(
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

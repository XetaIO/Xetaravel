<div class="form-group {{ $errors->has($name) ? 'has-danger' : '' }}">
    @if ($label !== false)
        {!! Form::label($name, $label, ['class' => $labelClass]) !!}
    @endif

    {!! Form::select(
        $name,
        $list,
        $selected,
        array_merge(['class' => $errors->has($name) ? 'form-control form-control-danger' : 'form-control'], $attributes)
    ) !!}

    @if ($errors->has($name))
        <div class="form-control-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>

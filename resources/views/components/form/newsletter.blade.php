<div class="{{ $errors->has($name) ? 'has-danger' : '' }}">
    <div class="input-group">
        {!! Form::email(
            $name,
            $value,
            array_merge(['class' => $errors->has($name) ? 'form-control form-control-danger' : 'form-control'], $attributes)
        ) !!}

        {!! Form::button('<i class="far fa-paper-plane"></i> Subscribe', ['type' => 'submit', 'class' => 'input-group-addon btn btn-outline-primary']) !!}
    </div>

    @if ($errors->has($name))
        <div class="form-control-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>

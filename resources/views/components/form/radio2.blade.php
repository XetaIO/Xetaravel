<div class="form-group {{ $errors->has($name) ? 'has-danger' : '' }}">
    @isset($attributes['label'])
        {!! Form::label($name, $attributes['label'], ['class' => $labelClass]) !!}
    @endisset

    <label class="{{ isset($attributes['labelClass']) ? $attributes['labelClass'] : 'custom-control custom-radio' }}">
        {!! Form::radio($name, $value, $checked, array_merge(['class' => 'custom-control-input'], $attributes)) !!}
        <span class="custom-control-indicator"></span>
        <span class="custom-control-description">{{ $label }}</span>
    </label>
    @if ($errors->has($name))
        <div class="form-control-feedback">
            {{ $errors->first($name) }}
        </div>
    @endif
</div>

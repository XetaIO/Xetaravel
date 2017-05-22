{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="form-group {{ $errors->has($errorName) || ($errors->has('slug') && in_array($errorName, ['title', 'name'])) ? 'has-danger' : '' }}">
    @if ($label !== false)
        {!! Form::label($name, $label, ['class' => $labelClass]) !!}
    @endif

    {!! Form::text(
        $name,
        $value,
        array_merge(['class' => $errors->has($errorName) ? 'form-control form-control-danger' : 'form-control'], $attributes)
    ) !!}

    @if ($errors->has($errorName))
        <div class="form-control-feedback">
            {{ $errors->first($errorName) }}
        </div>
    @endif

    @if ($errors->has('slug') && in_array($errorName, ['title', 'name']))
        <div class="form-control-feedback">
            {{ $errors->first('slug') }}
        </div>
    @endif

    @isset($attributes['formText'])
        <small class="form-text text-muted">
            {{ $attributes['formText'] }}
        </small>
    @endisset
</div>

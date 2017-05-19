{{-- Required for multiple select --}}
@php
    $errorName = str_replace('[', '', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="form-group {{ $errors->has($errorName) ? 'has-danger' : '' }}">
    @if ($label !== false)
        {!! Form::label($name, $label, ['class' => $labelClass]) !!}
    @endif

    {!! Form::select(
        $name,
        $list,
        $selected,
        array_merge(
            ['class' => $errors->has($errorName) ? 'form-control form-control-danger' : 'form-control'], $attributes
        ),
        $optionsAttributes
    ) !!}

    @if ($errors->has($errorName))
        <div class="form-control-feedback">
            {{ $errors->first($errorName) }}
        </div>
    @endif
</div>

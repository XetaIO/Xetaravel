{{-- Required for association field --}}
@php
    $errorName = str_replace('[', '.', $name);
    $errorName = str_replace(']', '', $errorName);
    $hasError = $errors->has($errorName) || ($errors->has('slug') && in_array($errorName, ['title', 'name'])) ? true : false;
@endphp

<div class="form-control">
    @if ($label !== false)
        <label class="label">
            <span class="label-text {{ $labelClass }}">{{ $label }}</span>
        </label>
    @endif

    {!! Form::text(
        $name,
        $value,
        array_merge(['class' => $hasError ? 'input input-bordered input-error w-full max-w-xs' : 'input input-bordered w-full max-w-xs'], $attributes)
    ) !!}

    @if ($errors->has($errorName))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($errorName) }}</span>
        </label>
    @endif

    @if ($errors->has('slug') && in_array($errorName, ['title', 'name']))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first('slug') }}</span>
        </label>
    @endif

    @isset($attributes['formText'])
        <small class="form-text text-muted">
            {{ $attributes['formText'] }}
        </small>
    @endisset
</div>

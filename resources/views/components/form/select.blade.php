{{-- Required for multiple select --}}
@php
    $errorName = str_replace('[', '', $name);
    $errorName = str_replace(']', '', $errorName);
@endphp

<div class="form-control">
    @if ($label !== false)
        <label class="label">
            <span class="label-text {{ $labelClass }}">{{ $label }}</span>
        </label>
    @endif

    {!! Form::select(
        $name,
        $list,
        $selected,
        array_merge(
            ['class' => $errors->has($errorName) ? 'select select-bordered select-error w-full max-w-xs' : 'select select-bordered w-full max-w-xs'], $attributes
        ),
        $optionsAttributes
    ) !!}

    @if ($errors->has($errorName))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($errorName) }}</span>
        </label>
    @endif
</div>

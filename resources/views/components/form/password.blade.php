<div class="form-control">
    <label class="label">
        <span class="label-text">{{ $label }}</span>
    </label>

    {!! Form::password(
        $name,
        array_merge(['class' => $errors->has($name) ? 'input input-bordered input-error w-full max-w-xs' : 'input input-bordered w-full max-w-xs'], $attributes)
    ) !!}

    @if ($errors->has($name))
        <label class="label">
            <span class="label-text-alt text-error">{{ $errors->first($name) }}</span>
        </label>
    @endif
</div>
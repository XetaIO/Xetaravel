@props([
    'label' => false
])

<div class="form-control">
    @if ($label !== false)
        <label class="label">
            <span class="label-text">{{ $label }}</span>
        </label>
    @endif
    <p class="mt-3">
        {{ $slot }}
    </p>
</div>
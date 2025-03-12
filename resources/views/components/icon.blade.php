@if(strlen($label ?? '') > 0)
    <div class="inline-flex items-center gap-1">
        @endif
        <x-svg
            :name="$icon()"
            {{
                $attributes->class([
                    'inline',
                    'w-5 h-5' => !Str::contains($attributes->get('class') ?? '', ['w-', 'h-'])
                ])
             }}
        />

        @if(strlen($label ?? '') > 0)
            <div class="{{ $labelClasses() }}">
                {{ $label }}
            </div>
    </div>
@endif

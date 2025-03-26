@if($link)
    <a href="{!! $link !!}"
@else
    <button
        {{ $attributes->whereDoesntStartWith('class')->merge(['type' => 'button']) }}
@endif

        wire:key="{{ $uuid }}"
        {{ $attributes->class(['btn', "!inline-flex lg:tooltip $tooltipPosition" => $tooltip]) }}

        @if($link && $external)
            target="_blank"
        @endif

        @if($link && !$external && $wireNavigate)
            wire:navigate
        @endif

        @if($tooltip)
            data-tip="{{ $tooltip }}"
        @endif

        @if($spinner)
            wire:target="{{ $spinnerTarget() }}"
        wire:loading.attr="disabled"
        @endif
    >

        <!-- SPINNER LEFT -->
        @if($spinner && !$iconRight)
            <span wire:loading wire:target="{{ $spinnerTarget() }}" class="loading loading-spinner w-5 h-5"></span>
        @endif

        <!-- ICON -->
        @if($icon)
            <span class="block" @if($spinner) wire:loading.class="hidden" wire:target="{{ $spinnerTarget() }}" @endif>
                <x-icon :name="$icon" :class="$iconClasses ?: 'h-4 w-4'" />
            </span>
        @endif

        <!-- LABEL / SLOT -->
        @if($label)
            <span @class(["hidden lg:block" => $responsive ])>
                {{ $label }}
            </span>
            @if(strlen($badge ?? '') > 0)
                <span class="badge badge-sm {{ $badgeClasses }}">{{ $badge }}</span>
            @endif
        @else
            {{ $slot }}
        @endif

        <!-- ICON RIGHT -->
        @if($iconRight)
            <span class="block" @if($spinner) wire:loading.class="hidden" wire:target="{{ $spinnerTarget() }}" @endif>
                <x-icon :name="$iconRight" :class="$iconClasses ?: 'h-4 w-4'" />
            </span>
        @endif

        <!-- SPINNER RIGHT -->
        @if($spinner && $iconRight)
            <span wire:loading wire:target="{{ $spinnerTarget() }}" class="loading loading-spinner w-5 h-5"></span>
        @endif

@if(!$link)
    </button>
@else
    </a>
@endif

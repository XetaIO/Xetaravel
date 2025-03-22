<div id="{{ $anchor }}" {{ $attributes->class(["mb-10", "header-anchor" => $withAnchor]) }}>
    <div class="flex flex-wrap gap-5 justify-between items-center">
        <div>
            <div @class(["$size font-extrabold", is_string($title) ? '' : $title?->attributes->get('class') ]) >
                @if($withAnchor)
                    <a href="#{{ $anchor }}">
                        @endif

                        {{ $title }}

                        @if($withAnchor)
                    </a>
                @endif
            </div>

            @if($subtitle)
                <div @class(["text-base-content/50 text-sm mt-1", is_string($subtitle) ? '' : $subtitle?->attributes->get('class') ]) >
                    {{ $subtitle }}
                </div>
            @endif
        </div>

        @if($middle)
            <div @class(["flex items-center justify-center gap-3 grow order-last sm:order-none", is_string($middle) ? '' : $middle?->attributes->get('class')])>
                <div class="w-full lg:w-auto">
                    {{ $middle }}
                </div>
            </div>
        @endif

        <div @class(["flex items-center gap-3", is_string($actions) ? '' : $actions?->attributes->get('class') ]) >
            {{ $actions}}
        </div>
    </div>

    @if($separator)
        <hr class="border-base-content/10 mt-3" />

        @if($progressIndicator)
            <div class="h-0.5 -mt-4 mb-4">
                <progress
                    class="progress progress-primary w-full h-0.5"
                    wire:loading

                    @if($progressTarget())
                        wire:target="{{ $progressTarget() }}"
                    @endif></progress>
            </div>
        @endif
    @endif
</div>

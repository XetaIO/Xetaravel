<div wire:key="datepicker-{{ rand() }}">
    @php
        // We need this extra step to support models arrays. Ex: wire:model="emails.0"  , wire:model="emails.1"
        $uuid = $uuid . $modelName()
    @endphp

    <fieldset class="fieldset py-0">
        {{-- STANDARD LABEL --}}
        @if($label && !$inline)
            <legend class="fieldset-legend mb-0.5">
                {{ $label }}

                @if($attributes->get('required'))
                    <span class="text-error">*</span>
                @endif
            </legend>
        @endif

        <label @class(["floating-label" => $label && $inline])>
            {{-- FLOATING LABEL--}}
            @if ($label && $inline)
                <span class="font-semibold">{{ $label }}</span>
            @endif

            <div class="w-full">
                {{-- PREPEND --}}
                @if($prepend)
                    {{ $prepend }}
                @endif

                {{-- THE LABEL THAT HOLDS THE INPUT --}}
                <label
                    @if($isDisabled())
                        disabled
                    @endif

                    {{
                        $attributes->whereStartsWith('class')->class([
                            "input w-full",
                            "join-item" => $prepend || $append,
                            "border-dashed" => $isReadonly(),
                            "!input-error" => $errorFieldName() && $errors->has($errorFieldName()) && !$omitError
                        ])
                    }}
                >

                    {{-- ICON LEFT --}}
                    @if($icon)
                        <x-icon :name="$icon" class="pointer-events-none w-4 h-4 -ml-1 opacity-40" />
                    @endif

                    {{-- INPUT --}}
                    <div
                        x-data="{
                            instance: undefined,
                            date: $wire.{{ $modelName() }} ? $wire.{{ $modelName() }} : new Date()
                        }"
                        x-init="instance = flatpickr($refs.input, {{ $setup() }}).setDate(date);"
                        @if(isset($config["mode"]) && $config["mode"] == "range" && $attributes->get('live'))
                            @change="const value = $event.target.value; if(value.split('to').length == 2) { $wire.set('{{ $modelName() }}', value) };"
                        @endif
                        x-on:livewire:navigating.window="instance.destroy();"
                        class="w-full"
                    >
                        <input x-ref="input" {{ $attributes->merge(['type' => 'date']) }} />
                    </div>


                    {{-- ICON RIGHT --}}
                    @if($iconRight)
                        <x-icon :name="$iconRight" class="pointer-events-none w-4 h-4 opacity-40" />
                    @endif
                </label>

                {{-- APPEND --}}
                @if($append)
                    {{ $append }}
                @endif
            </div>
        </label>

        {{-- ERROR --}}
        @if(!$omitError && $errors->has($errorFieldName()))
            @foreach($errors->get($errorFieldName()) as $message)
                @foreach(Arr::wrap($message) as $line)
                    <div class="{{ $errorClass }}" x-class="text-error">{{ $line }}</div>
                    @break($firstErrorOnly)
                @endforeach
                @break($firstErrorOnly)
            @endforeach
        @endif

        {{-- HINT --}}
        @if($hint)
            <div class="{{ $hintClass }}" x-classes="fieldset-label">{{ $hint }}</div>
        @endif
    </fieldset>
</div>

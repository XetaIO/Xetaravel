<div>
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
                <span class="text-[1.3em] font-semibold">{{ $label }}</span>
            @endif

            <div class="w-full">
                {{-- TEXTAREA --}}
                <textarea
                    placeholder="{{ $attributes->get('placeholder') }} "

                               {{
                                    $attributes->merge(['id' => $uuid])
                                    ->class([
                                        "textarea w-full",
                                        "border-dashed" => $attributes->has("readonly") && $attributes->get("readonly") == true,
                                        "!textarea-error" => $errorFieldName() && $errors->has($errorFieldName()) && !$omitError
                                    ])
                               }}
                            >{{ $slot }}</textarea>
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

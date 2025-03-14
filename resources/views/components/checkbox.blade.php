<div>
    <fieldset class="fieldset">
        <div class="w-full">
            <label @class(["flex gap-3 items-center cursor-pointer", "justify-between" => $right, "!items-start" => $hint])>

                {{-- CHECKBOX --}}
                <input
                    id="{{ $uuid }}"
                    type="checkbox"
                    {{
                        $attributes->whereDoesntStartWith("id")
                            ->class(["order-2" => $right])
                            ->merge(["class" => "checkbox"])
                     }}
                />

                {{-- LABEL --}}
                <div @class(["order-1" => $right])>
                    <div class="text-sm font-medium">
                        {!! $label !!}

                        @if($attributes->get('required'))
                            <span class="text-error">*</span>
                        @endif
                    </div>

                    {{-- HINT --}}
                    @if($hint)
                        <div class="{{ $hintClass }} font-normal text-right text-xs pt-1" x-classes="fieldset-label">{{ $hint }}</div>
                    @endif
                </div>
            </label>
        </div>

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
    </fieldset>
</div>

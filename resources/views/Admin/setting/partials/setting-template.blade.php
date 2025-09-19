@if(is_bool($setting->value))
    {{-- Trick to get all time the input name in the request input even when not checked --}}
    <input type="hidden" name="{{ $setting->key }}" value="0" />
    <x-form.checkbox
        :name="$setting->key"
        :label="$setting->label"
        :text="$setting->text"
        :checked="$setting->value"
    />
@endif

@if(is_int($setting->value))
    <x-form.input
        type="number"
        :name="$setting->key"
        :label="$setting->label"
        :value="$setting->value"
    />
@endif

@if(is_float($setting->value))
    <x-form.input
        type="number"
        :name="$setting->key"
        :label="$setting->label"
        :value="$setting->value"
        step=0.01
    />
@endif

@if(is_string($setting->value))
    <x-form.textarea
        type="text"
        :name="$setting->key"
        :label="$setting->label"
        :value="$setting->value"
    >{{ $setting->value }}</x-form.textarea>
@endif

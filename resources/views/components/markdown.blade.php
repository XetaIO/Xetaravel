<div>
    <fieldset class="fieldset py-0">
        {{-- STANDARD LABEL --}}
        @if($label)
            <legend class="fieldset-legend mb-0.5">
                {{ $label }}

                @if($attributes->get('required'))
                    <span class="text-error">*</span>
                @endif
            </legend>
        @endif

        {{-- EDITOR --}}
        <div
            x-data="
                            {
                                editor: null,
                                value: @entangle($attributes->wire('model')),
                                uploadUrl: '{{ $uploadUrl }}?disk={{ $disk }}&folder={{ $folder }}&_token={{ csrf_token() }}',
                                uploading: false,
                                init() {
                                    this.initEditor()

                                    // Handles a case where people try to change contents on the fly from Livewire methods
                                    this.$watch('value', (newValue) => {
                                        if (newValue !== this.editor.value()) {
                                            this.value = newValue || ''
                                            this.editor.codemirror.setValue('')
                                            this.destroyEditor()
                                            this.initEditor()

                                        }
                                    })
                                },
                                destroyEditor() {
                                    this.editor.toTextArea();
                                    this.editor = null
                                },
                                initEditor() {
                                    this.editor = new EasyMDE({
                                            {{ $setup() }},
                                            element: $refs.markdown{{ $uuid }},
                                            initialValue: this.value ?? '',
                                            imageUploadFunction: (file, onSuccess, onError) => {
                                                if (file.type.split('/')[0] !== 'image') {
                                                    return onError('File must be an image.');
                                                }

                                                var data = new FormData()
                                                data.append('file', file)

                                                this.uploading = true

                                                fetch(this.uploadUrl, { method: 'POST', body: data })
                                                   .then(response => response.json())
                                                   .then(data => onSuccess(data.location))
                                                   .catch((err) => onError('Error uploading image!'))
                                                   .finally(() => this.uploading = false)
                                            }
                                        })
                                    this.editor.codemirror.on('change', () => this.value = this.editor.value())
                                }
                            }"
            wire:ignore
            x-on:livewire:navigating.window="destroyEditor()"
        >
            <div class="relative disabled text-base" :class="uploading && 'pointer-events-none opacity-50'">
                <textarea id="{{ $uuid }}" x-ref="markdown{{ $uuid }}" placeholder="{{ $attributes->get('placeholder') }}"></textarea>

                <div class="absolute top-1/2 start-1/2 !opacity-100 text-center hidden" :class="uploading && '!block'">
                    <div>Uploading</div>
                    <div class="loading loading-dots"></div>
                </div>
            </div>
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

        {{-- HINT --}}
        @if($hint)
            <div class="{{ $hintClass }}" x-classes="fieldset-label">{{ $hint }}</div>
        @endif
    </fieldset>
</div>

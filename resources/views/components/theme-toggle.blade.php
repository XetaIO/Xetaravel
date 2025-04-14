<div>
    <label
        for="{{ $uuid }}"
        x-data="themeToggleComponent('{{ $uuid }}', '{{ $lightTheme }}', '{{ $darkTheme }}', '{{ $lightClass }}', '{{ $darkClass }}')"
        x-init="init()"
        @toggle-theme.window="toggleFromEvent($event.detail)"
        class="swap swap-rotate"
        {{ $attributes }}
    >
        <input id="{{ $uuid }}" type="checkbox" class="theme-controller opacity-0" @click="toggle()" :value="theme" />

        <x-icon x-ref="sun" name="heroicon-o-sun" class="h-8 w-8 swap-on" />
        <x-icon x-ref="'moon'" name="heroicon-o-moon" class="h-8 w-8 swap-off" />
    </label>
</div>

@once
    @push('scripts')
        <script>
            function themeToggleComponent(uuid, lightTheme, darkTheme, lightClass, darkClass) {
                return {
                    uuid,
                    theme: localStorage.theme || lightTheme,
                    class: localStorage.class || lightClass,

                    init() {
                        this.updateIcons();
                        this.applyTheme();
                    },

                    toggle() {
                        this.theme = this.theme === lightTheme ? darkTheme : lightTheme;
                        this.class = this.theme === lightTheme ? lightClass : darkClass;
                        this.applyTheme();
                        window.dispatchEvent(new CustomEvent('toggle-theme', {
                            detail: this.uuid
                        }));
                    },

                    toggleFromEvent(sourceUuid) {
                        if (sourceUuid === this.uuid) return;
                        this.theme = localStorage.theme;
                        this.class = localStorage.class;
                        this.applyTheme();
                    },

                    applyTheme() {
                        localStorage.theme = this.theme;
                        localStorage.class = this.class;

                        document.documentElement.setAttribute('data-theme', this.theme);
                        document.documentElement.setAttribute('class', this.class);
                        document.getElementById('flatpickrCssFile').href =
                            this.theme === lightTheme
                                ? 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'
                                : 'https://npmcdn.com/flatpickr/dist/themes/dark.css';

                        this.updateIcons();
                    },

                    updateIcons() {
                        if (!this.$refs.sun || !this.$refs.moon) return;

                        const isLight = this.theme === lightTheme;
                        this.$refs.sun.classList.toggle('swap-on', isLight);
                        this.$refs.sun.classList.toggle('swap-off', !isLight);
                        this.$refs.moon.classList.toggle('swap-on', !isLight);
                        this.$refs.moon.classList.toggle('swap-off', isLight);
                    }
                };
            }
        </script>
    @endpush
@endonce

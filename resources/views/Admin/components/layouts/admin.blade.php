<!--
Conçu et développé par Emeric Fèvre.
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

        <!-- Meta -->
        {{ $meta }}

        <script type="text/javascript">
            /**
             * Dark Mode
             * On page load or when changing themes, best to add inline in `head` to avoid FOUC
             */
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
                document.documentElement.dataset.theme = "dark";
                localStorage.setItem('theme', 'dark');
                // Change the flatpickr theme to dark.
                document.getElementById('flatpickrCssFile').href = '{{ Vite::asset('resources/css/flatpickr_dark.css') }}';
            } else {
                localStorage.theme = 'light';
                document.documentElement.classList.remove('dark');
                document.documentElement.dataset.theme = 'light';
            }
        </script>

        <!-- Embed Styles -->
        @stack('style')

        <!-- Styles -->
        @livewireStyles
        @vite('resources/css/xetaravel.css')

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-97W18J74QL"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-97W18J74QL');
        </script>

        <!-- Embed Scripts -->
        @stack('scriptsTop')

        @persist('Flatpickr')
        <!-- Flatpickr -->
        <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/css/flatpickr.css') }}" id="flatpickrCssFile" />
        @endpersist
    </head>
    <body class="bg-base-200 dark:bg-base-100">

        <div class="drawer lg:drawer-open">
            <!-- Toggle Responsive-->
            <input id="xetaravel-drawer" type="checkbox" class="drawer-toggle" />

            <div class="drawer-content flex flex-col overflow-hidden min-h-screen">
                <!-- Header -->
                <x-Admin::layouts.elements.header />

                <main>
                    <!-- Content -->
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <x-Admin::layouts.elements.footer />

            </div>

            <!-- Sidebar -->
            <x-Admin::layouts.elements.sidebar />
        </div>

        <!-- Scroll to Top button -->
        <x-scrolltotop />

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Xetaravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

        @vite('resources/js/xetaravel.js')
        @livewireScriptConfig

        <!-- Embed Scripts -->
        @stack('scripts')

        <x-toaster-hub />
    </body>
</html>

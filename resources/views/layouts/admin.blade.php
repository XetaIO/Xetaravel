<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('app.name') }}</title>

        <!-- Meta -->
        @stack('meta')

        <script type="text/javascript">
            /**
             * Dark Mode
             * On page load or when changing themes, best to add inline in `head` to avoid FOUC
             */
            if (localStorage.getItem('nightMode') == 'true' ||
                (!('nightMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.dataset.theme = "dark";
                localStorage.setItem("nightMode", true);
            }
        </script>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Miriam+Libre:wght@400;700&display=swap" rel="stylesheet">

        <!-- Embed Styles -->
        @stack('style')
        @livewireStyles

        <!-- Styles -->
        <link href="{{ mix('css/xetaravel.min.css') }}" rel="stylesheet">

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('xetaravel.site.analytics_tracker_code') }}"></script>
        <script type="text/javascript">
            /**
             * Gogole Analytics
             */
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('xetaravel.site.analytics_tracker_code') }}');

        </script>

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body>

        <div id="xetaravel-vue">

            <div class="drawer drawer-mobile">
                <!-- Toggle Responsive-->
                <input id="xetaravel-drawer" type="checkbox" class="drawer-toggle" />

                <div class="drawer-content flex flex-col">
                    <!-- Header -->
                    @include('Admin::elements.header')

                    <!-- Flash Messages -->
                    @include('elements.flash')

                    <main>
                        <!-- Content -->
                        @yield('content')
                    </main>

                    <!-- Footer -->
                    @include('Admin::elements.footer')

                </div>

                <!-- Sidebar -->
                @include('Admin::elements.sidebar')
            </div>
        </div>

        <!-- Scroll to Top button -->
        <x-scrolltotop />

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Xetaravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/e3046f3b08.js" crossorigin="anonymous"></script>
        <script src="{{ mix('js/xetaravel.admin.min.js') }}"></script>
        @livewireScripts

        <!-- Embed Scripts -->
        @stack('scripts')
    </body>
</html>

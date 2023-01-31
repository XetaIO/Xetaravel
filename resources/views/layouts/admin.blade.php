<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('app.name') }}</title>

        <!-- Meta -->
        @stack('meta')

        <!-- Styles -->
        <link href="{{ mix('css/font-awesome-all.min.css') }}" rel="stylesheet">
        <link href="{{ mix('css/xetaravel.libs.min.css') }}" rel="stylesheet">
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

            /**
             * Dark Mode
             * On page load or when changing themes, best to add inline in `head` to avoid FOUC
             */
            if (localStorage.getItem('nightMode') === 'dark' || (!('nightMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
                document.documentElement.dataset.theme = "dark";
            } else {
                document.documentElement.classList.remove('light');
                document.documentElement.dataset.theme = "light";
            }

        </script>

        <!-- Embed Styles -->
        @stack('style')

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body>

        <!-- Header -->
        @include('Admin::elements.header')

        <!-- Flash Messages -->
        @include('elements.flash')

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @include('Admin::elements.interface')

                <!-- Content -->
                @yield('content')

                <!-- Footer -->
                @include('Admin::elements.footer')
            </div>
        </div>


        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Xetaravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

        <!-- Scripts -->
        <script src="{{ mix('js/lib.min.js') }}"></script>
        <script src="{{ mix('js/xetaravel.admin.min.js') }}"></script>

        <!-- Embed Scripts -->
        @stack('scripts')
    </body>
</html>

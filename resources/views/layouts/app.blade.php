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
        <link href="{{ mix('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ mix('css/bootstrap.plugins.min.css') }}" rel="stylesheet">
        <link href="{{ mix('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ mix('css/xetaravel.min.css') }}" rel="stylesheet">

        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Embed Styles -->
        @stack('style')

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body>

        <div id="app-vue">
            <!-- Header -->
            @include('elements.header')

            <!-- Flash Messages -->
            @include('elements.flash')

            <!-- Content -->
            @yield('content')
        </div>


        <!-- Footer -->
        @include('elements.footer')

        <!-- Scripts -->
        <script src="{{ mix('js/lib.min.js') }}"></script>

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.Xetaravel = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>
        <script src="{{ mix('js/xetaravel.min.js') }}"></script>
        <script src="https://kit.fontawesome.com/61f38896f8.js" crossorigin="anonymous"></script>

        <!-- Embed Scripts -->
        @stack('scripts')
    </body>
</html>

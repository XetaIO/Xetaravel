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

        <!-- Header -->
        @include('elements.header')

        <!-- Flash Messages -->
        @include('elements.flash')

        <!-- Content -->
        @yield('content')

        <!-- Footer -->
        @include('elements.footer')
    </body>
</html>
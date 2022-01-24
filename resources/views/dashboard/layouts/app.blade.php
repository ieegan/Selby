<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="has-navbar-fixed-top">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="home-url" content="{{ route('home') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        @include('dashboard.layouts.header')

        <div class="facade">
            @yield('content')
        </div>

        @include('dashboard.layouts.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/dashboard.js') }}"></script>
    @yield('script')
</body>

</html>

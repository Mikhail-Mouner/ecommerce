<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} @yield('title', '' )</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<meta name="robots" content="all,follow">-->
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">

    @include('front-end.includes._header-script')

    @yield('style','')
</head>
<body>

<div id="app" class="page-holder @if(request()->routeIs('frontend.details')) bg-light @endif">

    @include('front-end.includes._header')


    <!-- HERO SECTION-->
    <div class="container">
        @yield('content')
    </div>

    @include('front-end.includes._footer')
</div>

@include('front-end.includes._footer-script')

@stack('script','')
</body>
</html>